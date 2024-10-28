@extends('layouts.app', ['title' => 'Registered Subject of '. $student->name .' from Class '. $class->name])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Student Info') }}
            </h4>
        </header>
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Taken') }}
            </h4>
        </header>
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Available') }}
            </h4>
        </header>
    </div>

@endsection