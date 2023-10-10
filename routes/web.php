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



Route::get('/', function () {
    return view('home');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', function () {
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
    Route::get("/recommendation", "displayRecommendationPage");
    Route::get("/feedback", "displayFeedbackPage");
    Route::get("/parks", "displayParksPage");
    Route::get("/trails", "displayTrailsPage");
});
// password.request


// Reset password code from: https://laravel.com/docs/10.x/passwords

//Route::post('/reset_password_email', "sendEmail");







// Route::get('/forgot-password', function () {
//     return view('passwordreset');
// })->middleware('guest')->name('reset_password');


// Route::post('/forgot-password', function (Request $request) {
//     $request->validate(['email' => 'required|email']);

//     $user = User::where('email', $request->email)->first();

//     if (!$user) {
//         return back()->withErrors(['email' => __('We cannot find a user with that email address.')]);
//     }

//     $status = Password::sendResetLink(
//         $request->only('email')
//     );

//     return $status === Password::RESET_LINK_SENT
//         ? back()->with(['status' => __($status)])
//         : back()->withErrors(['email' => __($status)]);
// })->middleware('guest')->name('password.email');



// Route::post('/reset-password', function (Request $request) {
//     $request->validate([
//         'token' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|min:8|confirmed',
//     ]);
 
//     $status = Password::reset(
//         $request->only('email', 'password', 'password_confirmation', 'token'),
//         function (User $user, string $password) {
//             $user->forceFill([
//                 'password' => Hash::make($password)
//             ])->setRememberToken(Str::random(60));
 
//             $user->save();
 
//             event(new PasswordReset($user));
//         }
//     );
 
//     return $status === Password::PASSWORD_RESET
//                 ? redirect()->route('login')->with('status', __($status))
//                 : back()->withErrors(['email' => [__($status)]]);
// })->middleware('guest')->name('password.update');

// //Route::get('/reset_password_email', "displayResetPage")->name('reset_sent');

// Route::get('/reset-password/{token}', function (string $token) {
//     return view('passwordreset', ['token' => $token]);
// })->middleware('guest')->name('reset_sent');
