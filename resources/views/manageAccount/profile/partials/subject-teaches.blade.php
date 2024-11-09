<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Teaches Subject') }}
        </h3>
    </header>

    <div>
    @if ($subClassTeacher)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Form</th>
                    <th scope="col">Class Teaches</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($subClassTeacher as $index => $subject)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ 1 + $index }}</th>
                    <td>{{ $subject['subjectTeach'] }}</td>
                    <td>{{ $subject['subjectForm'] }}</td>
                    <td>
                        <ul class="mt-2">
                        @foreach ($subject['classNames'] as $className)
                            <li>{{ $className }}</li>
                        @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">No Subject Assiged</h4>
        </div>
    @endif
    </div>
</section>
