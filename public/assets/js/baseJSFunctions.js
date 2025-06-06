// Sweet Alert starts /////////////////
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function successMessage(message, url=""){
    customButton();
    Toast.fire({
        icon: 'success',
        title: message
    }).then(function () {
        window.location = url;
    });
}

function successMessageWithOutUrl(message){
    customButton();
    Toast.fire({
        icon: 'success',
        title: message
    });
}

function warningMessage(message){
    // customButton();
    Toast.fire({
        icon: 'warning',
        title: message
    });
}

function errorMessage(message){
    // customButton();
    Toast.fire({
        icon: 'error',
        title: message
    });
}

function errorMessageWithUrl(message, url=""){
    Toast.fire({
        icon: 'error',
        title: message
    }).then(function () {
        window.location = url;
    });
}

function showAnchorDeleteConfirmation(url) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $("#deletedAddress").prop("disabled", true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "get",
                success: function(response) {
                    var responseJSON = response.message;
                    successMessage(responseJSON, response.url);
                    $("#deletedAddress").prop("disabled", false);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var responseJSON = eval("(" + xhr.responseText + ")");
                    errorMessage(responseJSON.message);
                    setTimeout(() => {
                        $("#deletedAddress").prop("disabled", false);
                    }, 2000);
                }
            });
        }
    });
    
    // Toast.fire({
    //     title: 'Are you sure?',
    //     text: "You won't be able to revert this!",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes, delete it!'
    // }).then((result) => {
    //     if (result.value) {
    //         window.location.href = url;
    //     }
    // });
}
// Sweet Alert ends /////////////////

// Custom button on click of please wait message /////////////////////////
// function customButton(){
//     // Change the button text to "Please Wait"
//     $('#customButton').html('Please Wait');
//     $('#customButton').prop( "disabled", true);
//     // Add a spinner to the button
//     $('#customButton').append('<span class="spinner-border spinner-border-sm align-middle ms-2" role="status" aria-hidden="true"></span>');
// }

// function customButtonModal(){
//     // Change the button text to "Please Wait"
//     $('#customButtonModal').html('Please Wait');
//     $('#customButtonModal').prop( "disabled", true);
//     // Add a spinner to the button
//     $('#customButtonModal').append('<span class="spinner-border spinner-border-sm align-middle ms-2" role="status" aria-hidden="true"></span>');
// }

// function customButtonInitState(){
//     // Change the button text to "Please Wait"
//     $('#customButton').html('Please Wait');
//     // Add a spinner to the button
//     $('#customButton').append('<span class="spinner-border spinner-border-sm align-middle ms-2" role="status" aria-hidden="true"></span>');
// }
// Custom button ends /////////////////////////

// Validations ////
function validateEmail(email) {
    // Regular expression for a valid email address
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Test the email against the regular expression
    return emailRegex.test(email);
}

function validatePassword(password, minLength, maxLength) {
    // Check if the password length is within the specified range
    return password.length >= minLength && password.length <= maxLength;
}

function rangeValidate(range, pattern) {
    return range.match(pattern);
}

function rangeValidateMinMax(range, minLength, maxLength){
    return range < minLength || range > maxLength;
}

function listYears(targetElementId) {
    let dateDropdown = document.getElementById(targetElementId);

    let currentYear = new Date().getFullYear();
    let earliestYear = 2000;
    while (currentYear >= earliestYear) {
        let dateOption = document.createElement('option');
        dateOption.text = currentYear;
        dateOption.value = currentYear;
        dateDropdown.add(dateOption);
        currentYear -= 1;
    }
}

// input only number
function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!/[0-9]/.test(ch)) {
      evt.preventDefault();
    }
}

// ONLY LETTERS ARE ALLOWES
function isInputLetter(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!/[a-zA-Z]/.test(ch)) {
        evt.preventDefault();
    }
}

// ONLY LETTERS, NUMERIC ARE ALLOWES
function isInputBoth(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!/[a-zA-Z0-9]/.test(ch)) {
        evt.preventDefault();
    }
}
// Validations ends////

// Past date disabled
function pastDateDisable(date) {
    // $(function(){
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#'+date).attr('min', maxDate);
    // });
}
// Past date validation ends ////

// tool tip 
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function redirectPage(routeUrl, slug){ // need to add in baseJSFunction if used in multiple files
    let url = routeUrl.replace(':slug', slug);
    window.location.href = url;
}
// function startSubmitProgressbtn() {
//     $('.indicator-label').css('display', 'none');
//     $('.indicator-progress').css('display', 'block');
// }

// function stopSubmitProgressbtn() {
//     $('.indicator-label').css('display', 'block');
//     $('.indicator-progress').css('display', 'none');
// }

