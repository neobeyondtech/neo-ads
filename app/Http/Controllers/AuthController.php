<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Enums\Role;
use App\Facades\ActivityLog;

class AuthController extends Controller
{    
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/my-profile');
        }

        return view('login');
    }

    private function autoLoginFromCookie()
    {
        // Cek jika sudah login
        if (Auth::check()) {
            return true;
        }

        // Cek cookie remember_token
        $rememberToken = Cookie::get('remember_token');
        
        if ($rememberToken) {
            // Cari user berdasarkan token
            $user = User::where('remember_token', $rememberToken)->first();
            
            if ($user) {
                // Login user
                Auth::login($user);
                return true;
            }
        }
        
        return false;
    }

   public function login(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required',
            'g-recaptcha-response' => 'required'
        ]);

      //$response = Http::asForm()->post(
        $response = Http::asForm()->withoutVerifying()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]
        );

        if (! $response->json('success')) {
            ActivityLog::logAuth('failed', 'Failed login attempt - Invalid captcha');
            return back()->withErrors(['captcha' => 'Captcha tidak valid']);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            // 🔥 CEK EMAIL VERIFIED
            if (! Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                ActivityLog::logAuth('failed', 'Failed login attempt - Email not verified');
                return back()->withErrors([
                    'email' => 'Email belum diverifikasi. Silakan cek email Anda.',
                ]);
            }

            if(Auth::user()->role == Role::CUSTOMER){
                ActivityLog::logAuth('login', 'Customer logged in successfully');
                return redirect()->intended('/my-profile');
            }else{
                ActivityLog::logAuth('login', 'Admin logged in successfully');
                return redirect()->intended('/dashboard');
            }
        }
        ActivityLog::logAuth('failed', 'Failed login attempt - Invalid credentials');
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'agree'   => 'accepted',
        ]);

        // Simpan ke database MySQL
        $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

         $user->sendEmailVerificationNotification();

        ActivityLog::logCreated('user', 'Registered new account', 'App\Models\User', $user->id, $user->toArray());
        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
       $user = User::findOrFail($id);

        // Validasi hash email
        if (! hash_equals(
            sha1($user->getEmailForVerification()),
            $hash
        )) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        ActivityLog::logUpdated('user', 'Verified email address', 'App\Models\User', $user->id, $user->toArray());

        return redirect('/login')->with(
            'success',
            'Email berhasil diverifikasi, silakan login.'
        );
    }

    public function redirectGoogle()
    {
        //dd('route kepanggil');
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
            ]
        );

        Auth::login($user);

        ActivityLog::logAuth('login', 'Logged in with Google account');
        if(Auth::user()->role == Role::CUSTOMER){
            return redirect('/my-profile');
        }else{  
            return redirect('/dashboard');
        }
    }

    public function showLinkRequestForm()
    {
        return view('forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        ActivityLog::logAuth('info', 'Password reset link requested for email: ' . $request->email);
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Gagal mengirim email reset password.']);
    }

    public function showResetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
                event(new PasswordReset($user));
            }
        );

        ActivityLog::logAuth('info', 'Password reset attempt for email: ' . $request->email);

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Password berhasil diubah, silakan login.')
            : back()->withErrors(['email' => 'Token reset tidak valid atau kadaluarsa.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
