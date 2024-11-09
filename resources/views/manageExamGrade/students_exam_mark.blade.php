@extends('layouts.app', ['title' => 'Classroom Subject'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        
    {{ $class }} <hr>
    {{ $subject }} <hr>
    {{ $exam }} <hr>
    {{ $students }} <hr>
    </div>

@endsection