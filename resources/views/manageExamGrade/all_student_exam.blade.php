@extends('layouts.app', ['title' => 'List Of Examination'])

@section('content')

    @include('manageExamGrade.partials.filter')

    <div class="container">
        <div class="d-flex justify-content-end me-4">

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
                {{-- sorting status --}}
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
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>

                    @php $loopIndex = ($examinations->currentPage() - 1) * $examinations->perPage() + 1; @endphp
                    @foreach ($examinations as $index => $examination)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $loopIndex + $index }}</th>
                            <td>{{ $examination->name }}</td>
                            <td>{{ $examination->start_date }} - {{ $examination->end_date }} ({{ $duration[$index] }} days)</td>
                            <td>{{ $examination->release_date }}</td>
                            <td>{{ $examination->status }}</td>
                            <td>
                                <a href="" class="btn btn-primary tr-button">Add Examination Mark</a>
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