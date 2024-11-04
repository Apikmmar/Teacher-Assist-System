@extends('layouts.app', ['title' => 'List Of Examination'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
            
    <div class="d-flex justify-content-end me-4">

    @can('coordinator')
        <div>
            <a href="{{ route('add_examination') }}" class="btn tr-button btn-primary">Register Exam</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    @endcan

    @if ($examinations->isNotEmpty())
            <div>
                <form action="" method="get">
        
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-12 d-flex align-items-center">
                
                            <input id="ic" type="text" style="width: 200px" class="form-control me-2 @error('ic') is-invalid @enderror" name="search_student" placeholder="Search Examination Name" required autocomplete="ic" autofocus>
                            <button type="submit" class="btn btn-light" style="min-width: 50px; border-radius: 30%"><i class="bi bi-search" style="font-size: 1.2rem;"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div>
                <button type="button" class="btn tr-button btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filter Exam</button>

                @include('manageClassroom.partials.filter')
            </div>
        </div>

        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Duration of Examination</th>
                        <th scope="col">Status</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @php $loopIndex = ($examinations->currentPage() - 1) * $examinations->perPage() + 1; @endphp
                    @foreach ($examinations as $index => $examination)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $loopIndex + $index }}</th>
                            <td>{{ $examination->name }}</td>
                            <td>{{ $examination->start_date }} - {{ $examination->end_date }} ({{ $duration[$index] }} days)</td>
                            <td>{{ $examination->status }}</td>
                            <td>{{ $examination->type }}</td>
                            <td>
                            @can('coordinator')
                                <a href="" class="btn text-white btn-warning tr-button">Edit</a>
                                <button class="btn btn-danger tr-button">Delete</button>
                            @endcan
                            @if ($examination->status == 'Release')
                                <a href="" class="btn btn-success tr-button">Report</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                
                @if ($examinations->total() > 10)
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-center">
                                {{ $examinations->onEachSide(1)->appends(request()->query())->links() }}
                            </td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">Examinations Not Registered</h4>
        </div>
    @endif
    </div>

@endsection