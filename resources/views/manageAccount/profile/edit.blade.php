@extends('layouts.app', ['title' => 'Profile'])

@section('content')
<div class="py-12 fade-in-text">
    @include('layouts.message')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @include('manageAccount.profile.partials.update-profile-information-form')
        <hr>
        @include('manageAccount.profile.partials.update-password-form')
        <hr>
        @include('manageAccount.profile.partials.subject-teaches')
        
    </div>
</div>
    
@endsection