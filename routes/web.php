<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::controller(UserAuthController::class)->group(function () {
    Route::get('/register', 'displayRegisterPage')->middleware("guest");
    Route::post('/attempt_register', 'registerUser');
    Route::get("/login", "displayLoginPage")->name("login")->middleware("guest");
    Route::post("/attempt_login", "authenticate");
    Route::get("/logout", "logout");
});
