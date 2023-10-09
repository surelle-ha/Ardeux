<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\SecurityMFA;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\MFAEmail;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if($request->remember){
            Cache::put('rememberEmail', $request->email, 30 * 24 * 60);
        }else{
            Cache::forget('rememberEmail');
        }
        
        $user = User::where('email', ($credentials['email']))
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            if (Auth::user()->IsActive == '1') {
                session(['MFA' => 0]);
                if (Auth::user()->requireNewPassword == '1') {
                    return redirect('/');
                } else {
                    return redirect('/');
                }
            } else {
                Auth::logout();
                return back()->withErrors(['message' => 'Account Blocked. Please contact your administrator or Manager to learn more.']);
            }
        } else {
            return back()->withErrors(['message' => 'Invalid Credentials. Your email or password is incorrect.']);
        }
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect('/login');
    }
}