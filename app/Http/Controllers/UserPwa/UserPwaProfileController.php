<?php

namespace App\Http\Controllers\UserPwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPwaProfileController extends Controller
{
    /**
     * Display User PWA Profile Page
     */
    public function index()
    {
        $user = Auth::user();

        return view('userpwa.profile', compact('user'));
    }

    /**
     * Update Profile Details
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . ($user ? $user->id : 0),
        ]);

        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
