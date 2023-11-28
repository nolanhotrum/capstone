<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class UserAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->email_verified_at !== null && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or the email is not verified.',
        ])->onlyInput('email');
    }

    public function verifyEmail(Request $request, User $user, $token)
    {
        // Check if the token matches the user's remember_token
        if ($user->remember_token !== $token) {
            abort(403, 'Invalid token.');
        }

        // Update the user's email_verified_at field
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Redirect to the home page or wherever you want
        return redirect('/')->with('success', 'Email verified successfully.');
    }

    public function displayLoginPage()
    {
        return view("login");
    }

    public function displayRegisterPage()
    {
        return view("register");
    }

    public function displayRecommendationPage()
    {
        return view("recommendation");
    }

    public function displayFeedbackPage()
    {
        return view("feedback");
    }

    public function displayParksPage()
    {
        return view("parks");
    }

    public function displayTrailsPage()
    {
        return view("trails");
    }

    public function displayResetPage()
    {
        return view("passwordreset");
    }

    public function sendEmail()
    {
        return view("sentresetemail");
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users'), // Ensure email is unique
                ],
                'password' => 'required|string|confirmed|min:3',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
            ]);

            // Generate a verification token
            $verificationToken = Str::random(40);

            // Save the token to the user
            $user->remember_token = $verificationToken;
            $user->save();

            // Attempt to send the verification email
            try {
                $this->sendVerificationEmail($user);
                Log::info('Verification email sent successfully.');
            } catch (\Exception $e) {
                Log::error('Error sending verification email: ' . $e->getMessage());
                // You can choose to log the error and handle it as needed
            }

            return view("sentresetemail"); // or redirect to another page
        } catch (ValidationException $e) {
            // Validation failed, redirect back with errors
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Other exceptions (e.g., email sending error)
            Log::error('Error during registration: ' . $e->getMessage());

            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }


    protected function sendVerificationEmail($user)
    {
        try {
            $verificationUrl = $this->generateVerificationUrl($user);

            Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));
            Log::info('Verification email sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending verification email: ' . $e->getMessage());
        }

        return view("sentresetemail");
    }

    protected function generateVerificationUrl($user)
    {
        return route('verify.email', [
            'user' => $user,
            'token' => $user->remember_token,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
