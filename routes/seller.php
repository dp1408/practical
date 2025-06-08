<?php

use App\Http\Controllers\Auth\SellerAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SellerMiddleware;

Route::controller(SellerAuthController::class)->group(function(){
    Route::get("/", "index")->name("admin");
    Route::get("register", "register")->name("seller.register");
    Route::get("login", "login")->name("seller.login");
    Route::post("post-login", "postLogin")->name("seller.postLogin");
    Route::post("post-registration", "postRegistration")->name("seller.postRegistration");
    Route::get("logout", "logout")->name("seller.logout");
});

Route::group(["middleware" => ["SellerMiddleware", "auth:seller"]], function(){
    Route::controller(SellerAuthController::class)->group(function(){
        Route::get("dashboard", "dashboard")->name("seller.dashboard");
    });
});