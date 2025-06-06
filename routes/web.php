<?php

use App\Http\Controllers\Auth\WebAuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name("home");

Route::controller(WebAuthController::class)->group(function(){
    Route::get("/", "index")->name("home");
    Route::get("register", "register")->name("home.register");
    Route::get("login", "login")->name("home.login");
    Route::post("post-login", "postLogin")->name("home.postLogin");
    Route::post("post-registration", "postRegistration")->name("home.postRegistration");
    Route::post("logout", "logout")->name("home.logout");
});

Route::middleware("auth")->group(function () {
    Route::controller(UserController::class)->group(function(){
        Route::get("dashboard", "dashboard")->name("home.dashboard");
    });
});

Route::get("link", function () {
    Artisan::call("storage:link");
    return "<h3>Storage Linked</h3>";
});

Route::get("refresh", function () {
    Artisan::call("cache:clear");
    Artisan::call("config:clear");
    Artisan::call("route:clear");
    Artisan::call("view:clear");
    $command = "truncate -s 0 " . storage_path("logs/laravel.log");
    exec($command, $output, $return_var);

    return "<h3>System refreshed</h3>";
});