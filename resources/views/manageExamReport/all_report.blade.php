@extends('manageExamReport.report_app', ['title' => 'Main Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="row d-flex justify-content-center">
            <div class="report-col">
                <a href="{{ route('subject_report', ['id' => $examination->id]) }}" style="text-decoration: none;">
                    <div class="report-card card">
                        <div class="card-body text-center">
                            <h4 class="card-title">Subject Report</h4>
                        </div>
                        <img src="{{ asset('asset/default-image/report.png') }}" class="report-img" alt="Subject Report">
                    </div>
                </a>
            </div>
            <div class="report-col">
                <a href="" style="text-decoration: none;">
                    <div class="report-card card">
                        <div class="card-body text-center">
                            <h4 class="card-title">Form Report</h4>
                        </div>
                        <img src="{{ asset('asset/default-image/report.png') }}" class="report-img" alt="Form Report">
                    </div>
                </a>
            </div>
            <div class="report-col">
                <a href="" style="text-decoration: none;">
                    <div class="report-card card">
                        <div class="card-body text-center">
                            <h4 class="card-title">Class Report</h4>
                        </div>
                        <img src="{{ asset('asset/default-image/report.png') }}" class="report-img" alt="Class Report">
                    </div>
                </a>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="report-col col-md-6 col-lg-4" style="min-width: 500px">
                <a href="" style="text-decoration: none;">
                    <div class="report-card card">
                        <div class="card-body text-center">
                            <h4 class="card-title">Class Recomendation</h4>
                        </div>
                        <img src="{{ asset('asset/default-image/change-people.png') }}" class="report-img" alt="Subject Report">
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection