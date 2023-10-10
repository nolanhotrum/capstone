<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
 
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
        $user = new User;
        $user->password = Hash::make( $request->input("password") );
        $user->email = $request->input("email");
        $user->name = $request->input("name");
        $user->role = $request->input("role");
        $user->save();

        return view("login");
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/login');
    }


    

}