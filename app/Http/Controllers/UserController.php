<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->input('entries', 10);
        $users = User::with('role')
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->paginate($entries); 
        $users->appends([
            'search' => $request->input('search'),
            'entries' => $entries,
        ]);
        $roles = Role::all();
        $colors = ['danger', 'info', 'secondary', 'primary', 'success', 'warning'];
        $roleColors = [];
        foreach ($roles as $role) {
            $roleColors[$role->name] = $colors[array_rand($colors)];
        }
        return view('users.index', compact('users', 'roles', 'roleColors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        $request['password'] = Hash::make($request->password);
        User::create($request->all());
        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($request->all());
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
