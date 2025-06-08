<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterClassroomRequest;
use App\Http\Requests\UpdateClassInfoRequest;
use App\Models\Classroom;
use App\Models\Form;
use App\Models\Role_User;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ClassroomController extends Controller
{
    public function viewAllClassroom(Request $request): View {

        if($request->class_form != '') {
            $classrooms = Classroom::where('form_id', $request->class_form)->orderBy('form_id', 'asc')->orderBy('name', 'asc')->paginate(10);
        } else {
            $classrooms = Classroom::orderBy('form_id', 'asc')->paginate(10);
        }

        $classrooms = $this->setTeacherName($classrooms);
    
        return view('manageClassroom.manageClass.all_classroom', [
            'classrooms' => $classrooms,
            'forms' => Form::all(),
        ]);
    }

    public function viewAddClassroom(): View {
        $stdSelected = [];
        $forms = Form::all();
        $students = Student::where('classroom_id', NULL)->where('status', 'Active')->get();

        $yearNow = date('Y');
    
        foreach ($students as $student) {
            $ageOnIc = substr($student->ic, 0, 2);
            $century = ($ageOnIc > $yearNow - 2000) ? 1900 : 2000;
            $student->age = $yearNow - ($century + $ageOnIc);
        }

        $availableTeachers = User::whereDoesntHave('classroom', function($query) {
            $query->whereNotNull('classteacher_id');
        })->get();

        foreach ($availableTeachers as $teacher) {
            $teacher->name = (strtolower($teacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ') . Str::title($teacher->name);
        }

        return view('manageClassroom.manageClass.add_classroom', [
            'stdSelected' => $stdSelected,
            'forms' => $forms,
            'students' => $students,
            'availableTeachers' => $availableTeachers
        ]);
    }

    public function viewClassroomDetails($id): View {;
        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.view_classroom', $data);
    }

    public function viewClassTeacherClassroom(): View {
        $user = Auth::user();
        $id = $user->classroom->id;

        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.view_classroom', $data);
    }

    public function viewEditClassroom($id): View {
        $data = $this->getClassroomData($id);

        return view('manageClassroom.manageClass.edit_classroom', $data, [
            'forms' => Form::all(),
            'teachers' => User::all(),
        ]);
    }

    public function registerNewClassroom(RegisterClassroomRequest $request) {
        $request->validated();

        $students = $request->input('students');

        $classroom = Classroom::create([
            'form_id' => $request->form,
            'name' => $request->name,
            'classteacher_id' => $request->class_teacher,
            'session' => now()->year,
            'num_student' => count($students),
        ]);

        $classroom->save();

        DB::table('role__users')->insert([
            'user_id' => $request->class_teacher,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($students as $std) {
            $student = Student::findOrFail($std);
            $student->classroom_id = $classroom->id;
            $student->save();
        }

        return redirect()->route('class_subject', ['id' => $classroom->id])->with('blue-message', 'Classroom Successfully Registered');
    }

    public function searchClassroomName(Request $request): View|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'search_classroom' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $searchTerm = $request->input('search_classroom');
        $classrooms =Classroom::where('name', 'LIKE', '%' . $searchTerm . '%')->paginate(10);
        $forms = Form::all();

        if ($classrooms->isEmpty()) {
            return redirect()->route('all_classroom')->with('red-message', 'Class Not Found.');
        }
        
        $classrooms = $this->setTeacherName($classrooms);

        return view('manageClassroom.manageClass.all_classroom', compact('classrooms', 'forms'));
    }

    public function updateClassroomInfo(UpdateClassInfoRequest $request, $id): RedirectResponse | View {
        
        $newData = $request->validated();
    
        $classroom = Classroom::findOrFail($id);
    
        $classroom->update($newData);
    
        return redirect()->route('view_classroom', ['id' => $id ])->with('blue-message', 'Classroom Info Successfully Updated');
    }
    
    public function deleteClassroom($id) {
        $class = Classroom::findOrFail($id);

        $students = $class->students;
        
        $roleUser = Role_User::where('user_id', $class->classteacher_id)->where('role_id', 1)->first();
        if ($roleUser) {
            $roleUser->delete();
        }

        Student::whereIn('id', $students->pluck('id'))->update(['classroom_id' => NULL]);

        $class->delete();

        return redirect()->route('all_classroom')->with('red-message', 'Classroom Is Deleted');
    }

    public function removeStudentClass($id): RedirectResponse {
        $std = Student::findOrFail($id);

        $class1 = $std->classroom_id;
        $name = $std->name;

        $std->classroom_id = null;
        $std->save();

        if ($class1) {
            $classroom = Classroom::findOrFail($class1);
            $classroom->num_student = $classroom->students()->count();
            $classroom->save();
        }

        return redirect()->route('edit_classroom', ['id' => $class1])->with('red-message', 'Student '. $name . ' Is Removed From Class ' . $classroom->name);
    }

    public function importClassroom(Request $request): RedirectResponse {
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

            // Normalize headers
            $headers = array_map(function($header) {
                return strtolower(trim($header));
            }, $headers);

            // Define expected columns and their mappings
            $expectedColumns = [
                'name' => ['name', 'class name', 'class'],
                'form' => ['form', 'form_id', 'form id', 'year'],
                'teacher' => ['teacher', 'class teacher', 'teacher name', 'classteacher'],
                'session' => ['session', 'year session', 'academic session']
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
                    $name = $rowData[$columnMap['name']] ?? null;
                    $form = $rowData[$columnMap['form']] ?? null;
                    $teacher = $rowData[$columnMap['teacher']] ?? null;
                    $session = $rowData[$columnMap['session']] ?? null;

                    // Validate required fields
                    if (empty($name) || empty($form) || empty($session)) {
                        throw new \Exception("Missing required fields (name, form, or session)");
                    }

                    // Handle teacher lookup
                    $ct_id = null;
                    if (!empty($teacher)) {
                        $class_teacher = User::where('name', 'LIKE', '%' . $teacher . '%')->first();
                        if (!$class_teacher) {
                            throw new \Exception("Teacher not found: {$teacher}");
                        }
                        $ct_id = $class_teacher->id;
                    }

                    $batchData[] = [
                        'name' => $name,
                        'form_id' => $form,
                        'classteacher_id' => $ct_id,
                        'num_student' => 0,
                        'session' => $session,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Insert in chunks for better performance
                    if (count($batchData) >= $chunkSize) {
                        Classroom::insert($batchData);
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
                Classroom::insert($batchData);
                $successCount += count($batchData);
            }

            fclose($handle);

            $message = "Successfully imported {$successCount} classroom records.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " records had errors.";
                return redirect()->route('all_classroom')->with('blue-message', $message)->with('red-message', implode('<br>', array_slice($errors, 0, 5)));
            }

            return redirect()->route('all_classroom')->with('blue-message', $message);

        } catch (\Exception $e) {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            
            return redirect()->route('all_classroom')->with('red-message', 'Import failed: ' . $e->getMessage());
        }
    }

    private function getClassroomData($id) {
        $classroom = Classroom::findOrFail($id);
        $students = Student::where('classroom_id', $classroom->id)->paginate(10);

        if ($classroom->classteacher != NULL) {
            $teacherName = Str::title($classroom->classteacher->name);

            if (strtolower($classroom->classteacher->gender) == 'men') {
                $teacherName = 'Mr. ' . $teacherName;
            } else {
                $teacherName = 'Mrs. ' . $teacherName;
            }
        } else {
            $teacherName = "N/A";
        }

        return [
            'classroom' => $classroom,
            'students' => $students,
            'teacherName' => $teacherName,
        ];
    }

    private function setTeacherName($classrooms) {

        foreach ($classrooms as $classroom) {
            if ($classroom->classteacher != NULL) {
                $teacherName = Str::title($classroom->classteacher->name);

                if (strtolower($classroom->classteacher->gender) == 'men') {
                    $classroom->teacher_title = 'Mr. ' . $teacherName;
                } else {
                    $classroom->teacher_title = 'Mrs. ' . $teacherName;
                }
            } else {
                $classroom->teacher_title = "N/A";
            }
        }

        return $classrooms;
    }
}
