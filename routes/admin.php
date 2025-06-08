<?php

use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleWare;


Route::controller(AdminAuthController::class)->group(function(){
    Route::get("/", "index")->name("admin");
    Route::get("register", "register")->name("admin.register");
    Route::get("login", "login")->name("admin.login");
    Route::post("post-login", "postLogin")->name("admin.postLogin");
    Route::post("post-registration", "postRegistration")->name("admin.postRegistration");
    Route::get("logout", "logout")->name("admin.logout");
});

Route::group(["middleware" => ["AdminMiddleware", "auth:admin"]], function(){
    Route::controller(AdminAuthController::class)->group(function(){
        Route::get("dashboard", "dashboard")->name("admin.dashboard");
    });
});
