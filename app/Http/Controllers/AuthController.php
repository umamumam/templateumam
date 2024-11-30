<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email or password is incorrect.'])->withInput($request->except('password'));
    }

    public function showRegister()
    {
        $roles = \App\Models\Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data['password'] = bcrypt($data['password']);

        \App\Models\User::create($data);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showDashboard()
    {
        $user = Auth::user();

        $menus = $user->role->menus()->orderBy('order')->get();

        return view('dashboard', compact('user', 'menus'));
    }
}
