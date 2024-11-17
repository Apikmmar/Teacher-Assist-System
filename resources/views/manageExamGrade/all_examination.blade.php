@extends('layouts.app', ['title' => 'List Of Examination'])

@section('content')

    @include('manageExamGrade.partials.filter')

    <div class="container fade-in-text">
        <div class="d-flex justify-content-end me-4">

        @can('coordinator')
            <div>
                <a href="{{ route('add_examination') }}" class="btn tr-button btn-primary">Register Exam</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        @endcan

        @if ($examinations->isNotEmpty())
            <div>
                <form action="{{ route('search_examination') }}" method="get">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-12 d-flex align-items-center">
                            <input id="search_examination"  type="text"  style="width: 200px"  class="form-control me-2 @error('search_examination') is-invalid @enderror"  name="search_examination"  placeholder="Search Examination Name"  required  autocomplete="search_examination"  autofocus>
                            <button type="submit" class="btn btn-light" style="min-width: 50px; border-radius: 30%">
                                <i class="bi bi-search" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div>
                <button type="button" class="btn tr-button btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filter Exam</button>
            </div>
        @endif
        
        </div>

    @if ($examinations->isNotEmpty())
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Duration of Examination</th>
                        <th scope="col">Status</th>
                        <th scope="col">Release Date</th>
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
                            <td>{{ $examination->release_date }}</td>
                            <td>{{ $examination->type }}</td>
                            <td>
                                <a href="{{ route('view_examination', ['id' => $examination->id ]) }}" class="btn text-white btn-warning tr-button">View</a>
                            
                            @can('coordinator')
                                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $examination->id }}" class="btn btn-danger tr-button">Delete</button>

                                @include('layouts.partials.modal', [
                                    'id' => $examination->id, 
                                    'name' => "Are you sure you want to remove " . $examination->name . " from from the database?",
                                    'deleteRoute' => route('delete.view_examination', ['id' => $examination->id]),
                                    'method' => 'DELETE'
                                ])
                            @endcan

                            @if ($examination->status == 'Release')
                                <a href="" class="btn btn-success tr-button">Report</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

                @if ($examinations->total() > 10)
                    <tfoot class="text-center">
                        <tr>
                            <td colspan="12" class="text-center">
                                {{ $examinations->onEachSide(5)->appends(request()->query())->links() }}
                            </td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
    </div>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">Examinations Not Registered</h4>
        </div>
    @endif
    
    </div>

@endsection