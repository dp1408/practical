@extends('layout.app')
@section('title', 'Admin Register')
@section('content')
<div class="container mt-5 card">
    <div class="d-flex justify-content-center align-items-center card-header">
        Admin Register
    </div>
    <div class="card-body">
        <form class="row" role="form" autocomplete="off" class="text-start" id="registerForm">
            @csrf
            <div class="form-group col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="John Doe" required autofocus>
                    <label for="full_name">Full Name <span class="text-danger">*</span></label>
                </div>
                @if ($errors->has('full_name'))
                    <span class="text-danger">{{ $errors->first('full_name') }}</span>
                @endif
            </div>
        
            <div class="form-group col-md-6">
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="9876543210" onkeypress="isInputNumber(event)" onpaste="return false;" minlength="10" maxlength="10" required>
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                </div>
                @if ($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            <div class="form-group col-md-12">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email_address" name="email" placeholder="John@gmail.com" required>
                    <label for="email_address">Email <span class="text-danger">*</span></label>
                </div>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

             <div class="form-group col-md-6">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="******" required>
                    <label for="password">Password <span class="text-danger">*</span></label>
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="******" required>
                    <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                </div>
                @if ($errors->has('confirm_password'))
                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                @endif
            </div>
        </form>
    </div>
    <div class="card-footer d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-success" onclick="validateRegisterForm()">Submit</button>
        <a class="btn btn-primary" href="{{route('admin.login')}}">Login</a>
    </div>
</div>
@endsection()
@push("scripts")
<script type="text/javascript">
    function validateRegisterForm() {
        var minLength = 6;
        var maxLength = 20;
        var number_pattern = /^\d{10}$/;
        event.preventDefault();
        var full_name = $("#full_name").val();
        var email = $("#email_address").val();
        var phone = $("#phone").val();
        var password = $("#password").val();
        var repeatPassword = $("#confirm_password").val();
        if(full_name == ''){
            warningMessage("Full Name must be required");
        } else if(phone == ''){
            warningMessage("Phone Number must be required");
        } else if(phone.length < 10 || phone.length > 10){
            warningMessage("Phone is not valid. It should be 10 digit.");
        } else if(!phone.match(number_pattern)){
            warningMessage("Phone number must be in digits.");
        } else if (email == '') {
            warningMessage("Email must be required");
        } else if(!validateEmail(email)) {
            warningMessage("Email is not valid");
        } else if (password == '') {
            warningMessage("Password must be required");
        } else if(password != "" && !validatePassword(password, minLength, maxLength)){
            warningMessage("New Password is not valid. It should be between " + minLength + " and " + maxLength + " characters.");
        } else if(password != "" && repeatPassword == ""){
            warningMessage("Please confirm your password");
        } else if(repeatPassword != "" && !validatePassword(repeatPassword, minLength, maxLength)){
            warningMessage("Confirm Password is not valid. It should be between " + minLength + " and " + maxLength + " characters.");
        } else if(password != repeatPassword){
            warningMessage("New password and confirm password does not matched");
        } else{
            // customButton();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.postRegistration') }}",
                type: "post",
                data:  {
                    name: full_name,
                    email: email,
                    phone: phone,
                    password: password,
                    confirm_password: repeatPassword,
                },
                success: function(response) {
                    var responseJSON = response.message;
                    successMessage(responseJSON, response.url);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var responseJSON = eval("(" + xhr.responseText + ")");
                    errorMessage(responseJSON.message);
                    // setTimeout(() => {
                    //     $('#customButton').html('Register');
                    //     $('#customButton').prop("disabled", false);
                    // }, 2000);
                }
            });
        }
    }
</script>
@endpush