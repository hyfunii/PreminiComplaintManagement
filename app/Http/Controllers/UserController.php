<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get(); // Fetch users with their roles
        $roles = Role::all(); // Fetch all roles
        $user = Auth::user();
        if ($user->role_id == 1) {
            return view('admin.other.user', compact('users', 'roles'));
        } else {
            return redirect()->back()->with('error', 'You not admin!');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();

            if ($errors->has('email')) {
                return redirect()->route('users.index')->with('error', 'This email is already used!');
            }

            if ($errors->has('password')) {
                return redirect()->route('users.index')->with('error', 'Password must be at least 8 characters long!');
            }

            return redirect()->route('users.index')->with('error', 'Validation failed!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An unexpected error occurred!');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role_id' => 'required|exists:roles,id',
                'password' => 'nullable|string|min:8',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Email already used!');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}