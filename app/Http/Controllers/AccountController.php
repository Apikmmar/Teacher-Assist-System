<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    //
    public function viewAllTeacher(): View {
        $teachers = User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->orderBy('ic', 'asc')->paginate(10);

        foreach ($teachers as $teacher) {
            $teacher->name =  Str::title($teacher->name);
        }

        return view('manageAccount.all_teacher', [
            'teachers' => $teachers,
        ]);
    }

    public function searchTeacherName(Request $request): View|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'search_teacher' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $searchTerm = $request->input('search_teacher');
        $teachers = User::where('name', 'LIKE', '%' . $searchTerm . '%')->paginate(10);

        if ($teachers->isEmpty()) {
            return redirect()->route('all_teacher')->with('red-message', 'Teacher Not Found.');
        }
        
        return view('manageAccount.all_teacher', compact('teachers'));
    }


    public function viewTeacherDetails($id): View {
        $teacher = User::findOrFail($id);
        $allRoles = Role::all();
        $teacher_roles = $teacher->roles;

        $teacher->name = Str::title($teacher->name);

        $ageOnIc = (substr($teacher->ic, 0, 2));
        
        $yearNow = date('Y');
        $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;

        $age = $yearNow - ($century + $ageOnIc);

        $subClassTeacher = $this->getTeachesSubjectClass($teacher);

        return view('manageAccount.teacher_details', compact('teacher', 'age', 'subClassTeacher', 'teacher_roles', 'allRoles'));
    }

    public function destroyTeacher($id): RedirectResponse {        
        $user = User::findOrFail($id);

        if($user->classroom) {
            $classes = Classroom::where('classteacher_id', $id)->get();
            
            foreach ($classes as $class) {
                $class->update(['classteacher_id' => NULL]);
            }
        }

        $user->delete();

        return redirect()->route('all_teacher')->with('red-message', 'Successfully Delete Teacher');
    }

    public function updateRoles(Request $request, $id): RedirectResponse {
        $request->validate([
            'roles' => ['array', 'min:1'],
        ]);

        $newRoleIDs = $request->input('roles');

        $user = User::findOrFail($id);

        $user->roles()->sync($newRoleIDs);

        return redirect()->route('view_teacher', ['id' => $user->id])->with('blue-message', 'Successfully Update Role');
    }

    public function importUser(Request $request): RedirectResponse {
        $request->validate([
            'import_csv' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('import_csv');
        
        try {
            $handle = fopen($file->path(), 'r');
            if ($handle === false) {
                throw new \Exception('Failed to open the CSV file.');
            }

            // Read and process header row to determine column positions
            $headers = fgetcsv($handle);
            if ($headers === false) {
                throw new \Exception('Empty CSV file or unable to read headers.');
            }

            // Normalize headers (trim, lowercase, etc.)
            $headers = array_map(function($header) {
                return strtolower(trim($header));
            }, $headers);

            // Define expected columns and their mappings
            $expectedColumns = [
                'teacher_id' => ['teacher_id', 'teacher id', 'id'],
                'name' => ['name', 'fullname', 'teacher name', 'full name'],
                'ic' => ['ic', 'ic number', 'nric', 'identification number'],
                'gender' => ['gender', 'sex'],
                'contact' => ['contact', 'phone', 'contact number', 'mobile'],
                'email' => ['email', 'email address']
            ];

            // Map headers to our expected columns
            $columnMap = [];
            foreach ($expectedColumns as $dbField => $possibleHeaders) {
                foreach ($possibleHeaders as $possibleHeader) {
                    $foundKey = array_search($possibleHeader, $headers);
                    if ($foundKey !== false) {
                        $columnMap[$dbField] = $foundKey;
                        break;
                    }
                }

                if (!isset($columnMap[$dbField])) {
                    throw new \Exception("Required column not found: " . implode('/', $possibleHeaders));
                }
            }

            $chunkSize = 25;
            $errors = [];
            $successCount = 0;
            $batchData = [];

            while (!feof($handle)) {
                $rowData = fgetcsv($handle);
                
                if ($rowData === false || empty(array_filter($rowData))) {
                    continue;
                }

                try {
                    // Map data using our column mapping
                    $teacher_id = $rowData[$columnMap['teacher_id']] ?? null;
                    $name = $rowData[$columnMap['name']] ?? null;
                    $ic = $rowData[$columnMap['ic']] ?? null;
                    $gender = $rowData[$columnMap['gender']] ?? null;
                    $contact = $rowData[$columnMap['contact']] ?? null;
                    $email = $rowData[$columnMap['email']] ?? null;

                    // Validate required fields
                    if (empty($teacher_id) || empty($name) || empty($ic) || empty($email)) {
                        throw new \Exception("Missing required fields");
                    }

                    // Validate IC number
                    if (strlen($ic) !== 12 || !ctype_digit($ic)) {
                        throw new \Exception("Invalid IC number (must be 12 digits)");
                    }

                    // Validate email format
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        throw new \Exception("Invalid email format");
                    }

                    $batchData[] = [
                        'teacher_id' => $teacher_id,
                        'name' => $name,
                        'ic' => $ic,
                        'gender' => $gender,
                        'contact' => $contact,
                        'email' => $email,
                        'password' => Hash::make($ic),
                        'verification' => null,
                        'photo' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Insert in chunks for better performance
                    if (count($batchData) >= $chunkSize) {
                        User::insert($batchData);
                        $successCount += count($batchData);
                        $batchData = [];
                    }

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($successCount + count($batchData) + count($errors) + 1) . ": " . $e->getMessage();
                    continue;
                }
            }

            // Insert any remaining records
            if (!empty($batchData)) {
                User::insert($batchData);
                $successCount += count($batchData);
            }

            fclose($handle);

            $message = "Successfully imported {$successCount} teacher records.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " records had errors.";
                return redirect()->route('all_teacher')->with('blue-message', $message)->with('red-message', implode('<br>', array_slice($errors, 0, 5))); // Show first 5 errors
            }

            return redirect()->route('all_teacher')->with('blue-message', $message);

        } catch (\Exception $e) {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            
            return redirect()->route('all_teacher')->with('red-message', 'Import failed: ' . $e->getMessage());
        }
    }

    private function getTeachesSubjectClass($user) {
        $subClassTeacher = [];

        foreach ($user->subjects as $subs) {
            $subjectTeach = $subs->name;
            $subjectForm = $subs->form->name;

            $takenSubjects = $user->subjecttaken->where('subject_id', $subs->id);

            $classNames = [];

            foreach ($takenSubjects as $takenSubject) {
                $class = Classroom::find($takenSubject->classroom_id);
                $classNames[] = $class ? $class->name : 'No Class Teaches';
            }

            if (empty($classNames)) {
                $classNames[] = 'No Class Teaches';
            }

            $subClassTeacher[] = [
                'subjectTeach' => $subjectTeach,
                'subjectForm' => $subjectForm,
                'classNames' => $classNames,
            ];
        }

        usort($subClassTeacher, function ($a, $b) {
            return strcmp($a['subjectForm'], $b['subjectForm']);
        });

        return $subClassTeacher;
    }
}
