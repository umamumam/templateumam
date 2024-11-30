<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Menampilkan daftar modul
    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    // Menampilkan form untuk membuat modul baru
    public function create()
    {
        return view('modules.create');
    }

    // Menyimpan modul baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Module::create($request->only('name'));

        return redirect()->route('modules.index')->with('success', 'Module created successfully');
    }

    // Menampilkan form untuk mengedit modul
    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    // Memperbarui modul
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $module->update($request->only('name'));

        return redirect()->route('modules.index')->with('success', 'Module updated successfully');
    }

    // Menghapus modul
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module deleted successfully');
    }
}
