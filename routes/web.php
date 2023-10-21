<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LocationController;

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

Auth::routes();

// test
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('password/reset', 'showLinkRequestForm')->name('reset_password');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
});
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/reset', 'reset')->name('password.update');
});


// If needed, uncomment the following line to add data to the database
// Route::get('/insert-data-from-json', [LocationController::class, 'insertDataFromJson']);

Route::get('/', [LocationController::class, 'showMap'])->name('home');

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/home', function () {
//     return view('home');
// });

Route::get('/login', function () {
    return view('login');
});


Route::controller(UserAuthController::class)->group(function () {

    Route::get('/register', 'displayRegisterPage')->middleware("guest");
    Route::post('/attempt_register', 'registerUser');
    Route::get("/login", "displayLoginPage")->name("login")->middleware("guest");
    Route::post("/attempt_login", "authenticate");
    Route::get("/logout", "logout");
    Route::get("/recommendation", "displayRecommendationPage");
    Route::get("/feedback", "displayFeedbackPage");
    Route::get("/parks", "displayParksPage");
    Route::get("/trails", "displayTrailsPage");
});
