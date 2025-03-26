<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'department' => 'required|string|max:255',
            'employee_id' => 'required|string|max:255|unique:users,employee_id,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->employee_id = $request->employee_id;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = $request->password;  // The model's mutator will handle the hashing

        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
} 