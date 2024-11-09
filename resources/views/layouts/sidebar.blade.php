<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="d-flex position-sticky justify-content-center">
        <div class="text-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('asset/default-image/smkb_logo.jpg') }}" style="max-width: 57px;" class="img-fluid" alt="SMK Baling.png">
            </a>
        </div>
    </div>
    <hr class="mt-1">
    <br><br><br>
    <div class="d-grid gap-3 justify-content-center">
        <a href="{{ route('all_classroom') }}" class="btn button-sidebar" type="button"><i class="bi bi-people me-2"></i>All Classroom</a>
        <a href="{{ route('all_teacher') }}" class="btn button-sidebar" type="button"><i class="bi bi-person-badge me-2"></i>Manage Teacher</a>
        <a href="{{ route('all_student') }}" class="btn button-sidebar" type="button"><i class="bi bi-person-check me-2"></i>Manage Student</a>
        
    @can('coordinator')
        <a href="{{ route('all_subjects') }}" class="btn button-sidebar" type="button"><i class="bi bi-book-half me-2"></i>Manage Subject</a>
    @endcan
    
    @can('classteachers-and-teachers')
        <a href="" class="btn button-sidebar" type="button"><i class="bi bi-person-lines-fill"></i>Student Examination</a>
    @endcan

        <a href="{{ route('all_examination') }}" class="btn button-sidebar" type="button"><i class="bi bi-pen-fill me-2"></i>Manage Examination</a>

        <form action="{{ route('logout') }}" method="post">
            @csrf
            
            <button type="submit" class="btn button-sidebar mt-3" type="button"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
        </form>
    </div>
</nav>