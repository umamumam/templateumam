<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->input('entries', 10);
        $menus = Menu::with('module', 'roles', 'children')
            ->whereNull('parent_id')
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
                })
            ->orderBy('order')
            ->paginate($entries);

        $menus->appends([
            'search' => $request->input('search'),
            'entries' => $entries,
        ]);

        return view('menus.index', compact('menus'));
    }



    public function create()
    {
        $modules = Module::all();
        $roles = Role::all();
        $menus = Menu::all();
        return view('menus.create', compact('modules', 'roles', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required',
            'link' => 'required|string',
            'order' => 'required|integer',
            'roles' => 'required|array',
            'parent_id' => 'nullable|exists:menus,id', // Validasi parent_id
        ]);

        $link = $request->link;
        if (!str_starts_with($link, '/')) {
            $link = '/' . $link;
        }

        $menu = Menu::create([
            'module_id' => $request->module_id,
            'name' => $request->name,
            'link' => $link,
            'order' => $request->order,
            'parent_id' => $request->parent_id,
        ]);

        $menu->roles()->sync($request->roles);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully');
    }

    public function edit(Menu $menu)
    {
        $modules = Module::all();
        $roles = Role::all();
        $menus = Menu::where('id', '!=', $menu->id)->get();
        return view('menus.edit', compact('menu', 'modules', 'roles', 'menus'));
    }


    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required',
            'link' => 'required|string',
            'order' => 'required|integer',
            'roles' => 'required|array',
            'parent_id' => 'nullable|exists:menus,id', // Validasi parent_id
        ]);

        $link = $request->link;
        if (!str_starts_with($link, '/')) {
            $link = '/' . $link;
        }

        $menu->update([
            'module_id' => $request->module_id,
            'name' => $request->name,
            'link' => $link,
            'order' => $request->order,
            'parent_id' => $request->parent_id,
        ]);

        $menu->roles()->sync($request->roles);

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully');
    }

    public function destroy(Menu $menu)
    {
        $menu->roles()->detach();
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully');
    }
}
