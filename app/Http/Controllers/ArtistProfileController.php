<?php

namespace App\Http\Controllers;

use App\Models\ArtistProfile;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistProfileController extends Controller
{
    // Ensure the user is an artist or customer before accessing the index method
    //public function __construct()
    //{
      //  $this->middleware(function ($request, $next) {
        //    if (Auth::check() && !in_array(Auth::user()->role, ['artist', 'customer'])) {
          //      return redirect()->route('home')->with('error', 'You must be an artist or customer to access this page.');
            //}
           // return $next($request);
        //});
    //}

    public function index()
{
    if (Auth::user()->role === 'customer' || Auth::user()->role === 'admin') {
        // Customers and admins can view all artist profiles
        $artists = ArtistProfile::all(); 
        return view('artist-profile.index', compact('artists'));
    } else {
        // Restrict access for other roles
        return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
    }
}

    // Show the artist profile
    public function show($userId)
    {
        $artistProfile = ArtistProfile::where('user_id', $userId)->first();
        $products = Product::where('user_id', $userId)->get();

        // Calculate total sales, but counting products for now
        
        return view('artist-profile.show', compact('artistProfile', 'products'));
    }

    // Show the edit form for the artist profile
    public function edit()
    {
        // Ensure the logged-in user is an artist before editing their profile
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('home')->with('error', 'You must be an artist to edit this profile.');
        }

        $artistProfile = Auth::user()->artistProfile ?? new ArtistProfile();
        return view('artist-profile.edit', compact('artistProfile'));
    }

    // Update the artist profile
    public function update(Request $request)
    {
        // Ensure the logged-in user is an artist before updating the profile
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('home')->with('error', 'You must be an artist to update this profile.');
        }

        $request->validate([
            'username' => 'nullable|string|max:255|unique:artist_profiles,username,' . Auth::id() . ',user_id', // Ensure uniqueness for the logged-in user
            'hometown' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $artistProfile = Auth::user()->artistProfile ?? new ArtistProfile(['user_id' => Auth::id()]);
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $artistProfile->profile_picture = $path;
        }
        $artistProfile->username = $request->username;
        $artistProfile->hometown = $request->hometown;
        $artistProfile->bio = $request->bio;
        $artistProfile->save();

        return redirect()->route('artist-profile.show', Auth::id())->with('success', 'Profile updated successfully.');
    }
}
