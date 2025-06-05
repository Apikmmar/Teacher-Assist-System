@extends('layouts.app', ['title' => 'Teacher Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Teacher Profile Section -->
        <div class="card-body">
            <div class="row">
                <!-- Teacher Photo -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="border rounded-3 p-2 bg-light" style="max-width: 250px; margin: 0 auto;">
                        <img src="{{ asset('storage/asset/profile-photos/' . $teacher->photo) }}" 
                                class="img-fluid rounded-2" 
                                alt="{{ $teacher->name }} profile photo">
                    </div>
                </div>
                
                <!-- Teacher Details -->
                <div class="col-md-8">
                    <div class="row g-3">
                        <!-- Identity Card Number -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Identity Card Number</label>
                            <div class="form-control bg-light">{{ $teacher->ic }}</div>
                        </div>
                        
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Name</label>
                            <div class="form-control bg-light">{{ $teacher->name }}</div>
                        </div>
                        
                        <!-- Age -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Age</label>
                            <div class="form-control bg-light">{{ $age }} years old</div>
                        </div>
                        
                        <!-- Teacher ID -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Teacher ID</label>
                            <div class="form-control bg-light">{{ $teacher->teacher_id }}</div>
                        </div>
                        
                        <!-- Gender -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Gender</label>
                            <div class="form-control bg-light">{{ $teacher->gender }}</div>
                        </div>
                        
                        <!-- Contact -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">Contact</label>
                            <div class="form-control bg-light">{{ $teacher->contact }}</div>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">Email</label>
                            <div class="form-control bg-light">{{ $teacher->email }}</div>
                        </div>
                        
                        <!-- Roles -->
                        @if ($teacher_roles->isNotEmpty())
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small mb-1">Roles</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($teacher_roles as $roles)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="bi bi-check-circle-fill me-1"></i>{{ $roles->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <!-- Update Roles Section (Coordinator Only) -->
        @can('coordinator')
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Update Teacher Roles</h5>
                <button class="btn btn-sm btn-outline-primary" id="updateRoleSwitch">
                    <i class="bi bi-pencil-square me-1"></i>Edit Roles
                </button>
            </div>
            
            <div class="card-body" id="updateRoleForm" style="display: none;">
                <form action="{{ route('update.teacher_role', ['id' => $teacher->id]) }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-9">
                            <div class="row g-3">
                                @foreach ($allRoles as $role)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                    name="roles[]" value="{{ $role->id }}" 
                                                    id="role-{{ $role->id }}"
                                                    @if(in_array($role->id, $teacher_roles->pluck('id')->toArray())) checked @endif>
                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-warning text-white w-100">
                                <i class="bi bi-save me-1"></i>Update Roles
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endcan
        <hr>

        <!-- Teaches Subjects Section -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-book me-2"></i>Teaches Subjects</h5>
        </div>
        
        <div class="card-body">
            @if ($subClassTeacher)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px">#</th>
                                <th scope="col"><i class="bi bi-book me-1"></i>Subject</th>
                                <th scope="col"><i class="bi bi-layers me-1"></i>Form</th>
                                <th scope="col"><i class="bi bi-people me-1"></i>Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subClassTeacher as $index => $subject)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td class="fw-medium">{{ $subject['subjectTeach'] }}</td>
                                    <td>{{ $subject['subjectForm'] }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($subject['classNames'] as $className)
                                                <li><span class="badge bg-secondary bg-opacity-10 text-dark">{{ $className }}</span></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-journal-x" style="font-size: 3rem; opacity: 0.2"></i>
                    </div>
                    <h5 class="text-muted">No Subjects Assigned</h5>
                    <p class="text-muted">This teacher is not currently assigned to any subjects</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('updateRoleSwitch').addEventListener('click', function() {
            const form = document.getElementById('updateRoleForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
            this.innerHTML = form.style.display === 'none' 
                ? '<i class="bi bi-pencil-square me-1"></i>Edit Roles' 
                : '<i class="bi bi-x-circle me-1"></i>Cancel';
        });
    </script>
@endsection