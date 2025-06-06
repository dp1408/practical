@extends('layout.app')
@section('title', 'Home')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome to the Home Page') }}</div>

                <div class="card-body">
                    <p>{{ __('This is the home page of your application.') }}</p>
                    <a class="btn btn-success" href="{{route('home.register')}}">Register</a>
                    <a class="btn btn-primary" href="{{route('home.login')}}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()