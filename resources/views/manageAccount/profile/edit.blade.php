@extends('layouts.app', ['title' => 'Profile'])

@section('content')
<div class="container fade-in-text">
    @include('layouts.message')
    
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-person-gear me-2"></i>Profile Settings</h2>
        </div>
        
        @include('manageAccount.profile.partials.update-profile-information-form')
    </div>
    <hr>
    <div class="card-body">
        @include('manageAccount.profile.partials.update-password-form')
    </div>
    <hr>
    <div class="card-body">
        @include('manageAccount.profile.partials.subject-teaches')
    </div>
</div>
@endsection