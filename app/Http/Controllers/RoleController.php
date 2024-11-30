<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->input('entries', 10);
        $roles = Role::when($request->input('search'), function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate($entries);
        $roles->appends([
            'search' => $request->input('search'),
            'entries' => $entries,
        ]);
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create($request->all());
        return redirect()->back()->with('success', 'Role added successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update($request->all());
        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }
}
