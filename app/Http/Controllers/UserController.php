<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Switch the role of the authenticated user.
     *
     * @param  string  $role
     * @return \Illuminate\Http\Response
     */
    public function switchRole($role)
    {
        // Validate that the role is either 'customer' or 'artist'
        if (!in_array($role, ['customer', 'artist'])) {
            return redirect()->route('home')->with('error', 'Invalid role.');
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // If the user already has the selected role, return an info message
        if ($user->role === $role) {
            return redirect()->route('dashboard', ['userId' => Auth::id()])
                ->with('info', 'You are already assigned the ' . ucfirst($role) . ' role.');
        }

        // Update the user's role and save the changes
        $user->role = $role;
        $user->save();

        // Redirect to the artist profile with a success message
        return redirect()->route('dashboard', ['userId' => Auth::id()])
            ->with('success', 'Role changed to ' . ucfirst($role) . ' successfully.');
    }
}
