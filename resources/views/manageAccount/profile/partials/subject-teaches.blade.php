<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Teached Subject') }}
        </h3>
    </header>

    <div>
        @if ($subjects->isNotEmpty())
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Form</th>
                    <th scope="col">Subject Descrption</th>
                </tr>
            </thead>
            <tbody>
            @php
                $startNumber = 1;
            @endphp
            @foreach ($subjects as $index => $subject)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ $startNumber + $index }}</th>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->form->name }}</td>
                    <td>
                    @foreach ($classTeaches as $item)
                        {{ $item->classroom_id }}
                    @endforeach
                    </td>
            @endforeach

            
            
        </table>
    @else
    
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">No Subject Assiged</h4>
        </div>
    @endif
    </div>
</section>
