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
use App\Http\Controllers\ParkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParksController;
use App\Http\Controllers\TrailsController;
use App\Http\Controllers\RecommendationController;
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
Route::get('/locations/{id}', [LocationController::class, 'showLocation'])->name('locations.show');

Route::post('/locations/{id}/comments', [CommentController::class, 'store'])->name('locations.comments.store')->middleware('auth');

Route::get('/locations/{id}/rate', [RatingController::class, 'showRatingView'])->name('locations.rate.view')->middleware('auth');

Route::post('/locations/{id}/rate/{ratingId}', [RatingController::class, 'replace'])->name('locations.rate.replace')->middleware('auth');

Route::post('/locations/{id}/rate', [RatingController::class, 'rate'])->name('locations.rate.submit')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'showParkRequests'])->name('admin');
    Route::get('/admin/recommendation/{id}/{action}', [RecommendationController::class, 'approveDeny'])->name('admin.recommendation.approveDeny');
});



Route::get('/login', function () {
    return view('login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/recommendation/create', [RecommendationController::class, 'create'])->name('recommendation.create');
    Route::post('/recommendation', [RecommendationController::class, 'store'])->name('recommendation.store');
});




Route::controller(UserAuthController::class)->group(function () {

    Route::get('/register', 'displayRegisterPage')->middleware("guest");
    Route::post('/attempt_register', 'registerUser');
    Route::get("/login", "displayLoginPage")->name("login")->middleware("guest");
    Route::post("/attempt_login", "authenticate");
    Route::get("/logout", "logout");
});


Route::middleware(['auth'])->group(function () {
    Route::controller(UserAuthController::class)->group(function () {
        Route::get("/recommendation", "displayRecommendationPage");
        Route::get('/parks', [ParksController::class, 'index']);
        Route::get("/trails", "displayTrailsPage");
    });
});

// Route::get('/parks/{park}', [ParkController::class, 'showParks'])->name('park.show');
