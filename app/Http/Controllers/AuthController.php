<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    //
    public function showlogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function registerUsers(Request $request)
    {
        try {
            $validateData = $request->validate([
                'email' => 'required|email|unique:users',
                'name' => 'required|string',
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/',
                ],
            ]);

            $user = User::create([
                'email' => $validateData['email'],
                'name' => $validateData['name'],
                'password' => Hash::make($validateData['password']),
                'user_type' => 2 
            ]);
            if($user){
                return redirect('login')->with('msg' ,'Registration Successfull');
            }
        } catch (ValidationException $e) {
            return redirect('register')->withErrors($e->errors())->withInput();
           
        }
    }


    public function loginUsers(Request $request) {
        try {
            $validateData = $request->validate([
                'email' => 'required',
                'password' => 'required|min:8',

            ]);
    
            if (Auth::attempt([
                'email' => $validateData['email'],
                'password' => $validateData['password'],
                'user_type' => 2,
            ])) {

                return redirect()->route('profile')->with('msg', 'Login Successful');

            }
    
            return back()->withErrors(['email' => 'These credentials do not match our records.']);
    
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    
    public function updateProfile(Request $request){
        $user = Auth::user(); 
        $user_id = $user->id;
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8|confirmed',
        ]);
    
        $user = User::find($user_id);
        if ($user) {
            $user->name = $validateData['name'];
            $user->email = $validateData['email'];
            if (!empty($validateData['password'])) { 
                $user->password = Hash::make($validateData['password']);
            }
            $user->save();
            
            return back()->with('msg', 'Profile Updated Successfully');
        }
    
        return back()->withErrors(['error' => 'User not found']);
    }

    public function userLogout()  {
        Auth::logout();
        return redirect('login')->with('msg', 'Profile Logout Successfully');
        
    }

   
    
    public function showForgotPasswordForm()
    {
        return view('forgot');
    }

    // Send Reset Link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']); 
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email], 
            ['token' => $token, 'created_at' => now()]
        );
        $resetLink = url('/reset_password/' . $token);
        Mail::raw("Click here to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Your Password');
        });
        return back()->with('msg', 'Reset link sent to your email!');
    }

  
    public function showResetPasswordForm($token)
    {
        return view('reset_password', compact('token'));
    }

    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $resetData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$resetData) {
            return back()->withErrors(['error' => 'Invalid or expired token.']);
        }

        User::where('email', $resetData->email)->update([
            'password' => Hash::make($request->password),
        ]);

        
        DB::table('password_reset_tokens')->where('email', $resetData->email)->delete();

        return redirect()->route('login')->with('msg', 'Password reset successful!');
    }



    }

