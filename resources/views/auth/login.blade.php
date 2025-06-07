@extends('layout.app')
@section('title', 'Login')
@section('content')
<div class="container mt-5 card">
    <div class="d-flex justify-content-center align-items-center card-header">
        User Login
    </div>
    <div class="card-body">
        <form role="form" autocomplete="off" class="text-start" id="loginForm">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email_address" placeholder="name@example.com" name="email" required autofocus>
                <label for="email_address">Email address</label>
            </div>
            @if ($errors->has("email"))
                <span class="text-danger">{{ $errors->first("email") }}</span>
            @endif
            <div class="form-group">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" placeholder="******" name="password" required autofocus>
                    <label for="password">Password</label>
                </div>
                @if ($errors->has("password"))
                    <span class="text-danger">{{ $errors->first("password") }}</span>
                @endif
            </div>
        </form>
    </div>
    <div class="card-footer d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-primary" onclick="validateLoginForm()" >Submit</button>
        <a class="btn btn-success" href="{{route('home.register')}}">Register</a>
    </div>
</div>
@endsection()
@push("scripts")
<script type="text/javascript">
    function validateLoginForm() {
        var minLength = 6;
        var maxLength = 20;
        event.preventDefault();
        var email = $("#email_address").val();
        var password = $("#password").val();
        if (email == '') {
            warningMessage("Email must be required");
        }
        else if(!validateEmail(email)) {
            warningMessage("Email is not valid");
        }
        else if(password == ''){
            warningMessage("Password must be required");
        }
        else if(!validatePassword(password, minLength, maxLength)){
            warningMessage("Password is not valid. It should be between " + minLength + " and " + maxLength + " characters.");
        }
        else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('home.postLogin') }}",
                type: "post",
                data:  {
                    email: email,
                    password: password
                },
                success: function(response) {
                    var responseJSON = response.message;
                    successMessage(responseJSON, response.url);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var responseJSON = eval("(" + xhr.responseText + ")");
                    if(responseJSON == undefined){
                        errorMessage("Something went wrong");
                    }
                    else{
                        errorMessage(responseJSON.message);
                    }
                    setTimeout(() => {
                        $('#customButton').html('Login');
                        $('#customButton').prop("disabled", false);
                    }, 2000);
                }
            });
        }
    }
</script>
@endpush