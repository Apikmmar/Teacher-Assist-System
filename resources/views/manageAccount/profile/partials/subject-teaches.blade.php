<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-primary">
            <i class="bi bi-book me-2"></i>{{ __('Teaching Assignments') }}
        </h3>
        <p class="text-muted mb-0">
            {{ __('Subjects and classes you are currently teaching.') }}
        </p>
    </header>

    @if ($subClassTeacher && count($subClassTeacher) > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Form</th>
                        <th scope="col">Classes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subClassTeacher as $index => $subject)
                        <tr>
                            <th scope="row" class="text-center">{{ $index + 1 }}</th>
                            <td>{{ $subject['subjectTeach'] }}</td>
                            <td>{{ $subject['subjectForm'] }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($subject['classNames'] as $className)
                                        @if ($className['class_id'])
                                            <a href="{{ route('view_classroom', ['id' => $className['class_id']]) }}" 
                                               class="badge bg-primary text-decoration-none">
                                                {{ $className['class_name'] }}
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">{{ $className['class_name'] }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>No teaching assignments have been assigned to you yet.
        </div>
    @endif
</section>