<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleWare;


Route::get('/', function () {
    return view('welcome');
});
