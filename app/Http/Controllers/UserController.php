<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index: list users (10 per page)
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(10);
        return view('users.index', compact('users'));
    }

    // show create form
    public function create()
    {
        return view('users.create');
    }

    // store new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,editor',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // show edit form
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // update user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,editor',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->role  = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
