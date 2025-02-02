<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminshowLogin()
    {
        return view('admin.login');
    }

    public function adminloginProcess(Request $request)
    {
        
        $validateData = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',

        ]);

        if (Auth::attempt([
            'email' => $validateData['email'],
            'password' => $validateData['password'],
            'user_type' => 1,
        ])) {

            return redirect()->route('dashboard')->with('msg', 'Login Successful');

        }

       
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function adminlogout()
    {
        Auth::logout();
        return redirect()->route('adminshowLogin')->with('msg', 'Logged out successfully');
    }

    public function dashboard()
    {
        
        $totalUsers = User::count();
       
        return view('admin/dashboard', compact('totalUsers'));
    }

    public function adminusers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function create() {
        return view('admin.create_users'); 
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                    'required',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/',
                ],
            'user_type' => 'required|in:1,2', // 1 = Admin, 2 = User
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);
    
        return redirect()->route('adminusers')->with('msg', 'User added successfully!');
    }
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('adminusers')->with('msg', 'User deleted successfully!');
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    
    if ($request->password) {
        $request->validate([
            'password' => 'confirmed|min:8',
        ]);
        $user->password = Hash::make($request->password);
    }

    
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()->route('adminusers')->with('msg', 'User updated successfully');
}

    
}
