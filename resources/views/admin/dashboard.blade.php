@extends('admin.layout.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('Welcome to the Admin Dashboard Page') }}
                    <a class="btn btn-danger" href="{{route('admin.logout')}}">Logout</a>
                </div>

                <div class="card-body">
                    <p>{{ __('This is the admin dashboard of your application.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()