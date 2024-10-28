<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $user = Auth::user();
        if ($user->role_id == 1) {
            return view('admin.other.role', compact('roles'));
        } else {
            return redirect()->back()->with('error', 'You not admin!');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'description' => 'nullable|string|max:255',
            ]);

            Role::create($request->all());

            return redirect()->route('roles.index')->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Role already exist!');
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'description' => 'nullable|string|max:255',
            ]);

            $role->update($request->all());

            return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Role already exist!');
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}

