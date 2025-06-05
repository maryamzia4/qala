<?php

namespace App\Http\Controllers;

use App\Models\CommissionRequest;
use App\Models\User;
use App\Mail\CommissionRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CommissionApproved;
use App\Mail\CommissionRejected; 


class CommissionController extends Controller
{
    public function store(Request $request)
    {
        // Log incoming data for debugging
        Log::info('Incoming commission request data: ', $request->all());

        // Validate the incoming data
        $validatedData = $request->validate([
            'artist_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'canvas_size' => 'required|string|max:50',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'budget' => 'nullable|string|max:255',
            'delivery_type' => 'required|in:digital,physical,both',
            'reference_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            

        ]);

        // Log validated data
        Log::info('Validated commission request data: ', $validatedData);

        // Handle reference image uploads
        $referenceImagePaths = [];
        if ($request->hasFile('reference_images')) {
            foreach ($request->file('reference_images') as $image) {
                $referenceImagePaths[] = $image->store('reference_images', 'public');
            }
            Log::info('Reference images uploaded: ', $referenceImagePaths);
        } else {
            Log::info('No reference images uploaded.');
        }

        // Create commission request and store in the database
        try {
            $commission = CommissionRequest::create([
                'artist_id' => $request->artist_id,
                'customer_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'title' => $request->title,
                'canvas_size' => $request->canvas_size,
                'description' => $request->description,
                'deadline' => $request->deadline,
                'budget' => $request->budget,
                'delivery_type' => strtolower($request->delivery_type), 
                'reference_images' => json_encode($referenceImagePaths), 
            ]);

            Log::info('Commission request created successfully: ', $commission->toArray());
        } catch (\Exception $e) {
            Log::error('Error creating commission request: ' . $e->getMessage());
        }

        // Send email to the artist
        try {
            $artist = User::find($request->artist_id);
            if ($artist) {
                Mail::to($artist->email)->send(new CommissionRequestMail($commission));
                Log::info('Email sent to artist: ' . $artist->email);
            } else {
                Log::warning('Artist not found for ID: ' . $request->artist_id);
            }
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
        }

        // Return response with success message
        return redirect()->route('commissions.create', ['artist_id' => $request->artist_id])
                         ->with('popup', 'Request submitted successfully!');
    }

    public function index(Request $request)
{
    // Start the query to get commissions for the logged-in artist
    $query = CommissionRequest::where('artist_id', Auth::id());

    // Check if there's a status filter and apply it
    if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'ready', 'delivered'])) {
        $query->where('status', $request->status);
    }

    // Get filtered commissions
    $commissions = $query->get();

    // Return view with the filtered commissions
    return view('commissions.index', compact('commissions'));
}


    /*public function respond(Request $request, $id)
    {
        // Find the commission request
        $commission = CommissionRequest::findOrFail($id);

        // Check if the logged-in user is the artist for this commission
        if ($commission->artist_id != Auth::id()) {
            abort(403); // Unauthorized
        }

        // Validate the response status
        $request->validate([
            'status' => 'required|in:approved,rejected',

        ]);

        // Update the commission status
        $commission->status = $request->input('status');
        $commission->save();

        return back()->with('success', 'Response recorded.');
    }
*/
    public function create($artist_id)
    {
        // Fetch the artist's details
        $artist = \App\Models\User::findOrFail($artist_id);
        return view('commissions.create', compact('artist'));
    }

    public function show($id)
{
    // Find the commission request by its ID
    $commission = CommissionRequest::findOrFail($id);

    // Check if the logged-in artist is the one assigned to the commission
    if ($commission->artist_id != Auth::id() && !Auth::user()->hasRole('admin')) {
    abort(403); // Unauthorized
}


    // Return the view with the commission details
    return view('commissions.view', compact('commission'));
}

public function approve($id)
    {
        $commission = CommissionRequest::findOrFail($id);
        
        // Update the commission status to approved
        $commission->status = 'approved';
        $commission->save();
        
        // Send an email to the customer
        Mail::to($commission->customer->email)->send(new CommissionApproved($commission));

        // Redirect back to the index page with a success message
        return redirect()->route('commissions.index')->with('success', 'Commission approved successfully!');
    }
    
    

/*public function rejected(Request $request, $id)
{
    $commission = CommissionRequest::findOrFail($id);


    $commission->status = $request->input('status');
    $commission->save();

    if ($commission->status === 'rejected') {
        Mail::to($commission->customer->email)->send(new CommissionRejected($commission));
    }

    return redirect()->route('commissions.index')->with('success', 'Request Rejected!');
}*/

public function markReady($id)
{
    $commission = CommissionRequest::findOrFail($id);

    // Allow only the assigned artist to mark as ready
    if ($commission->artist_id !== Auth::id()) {
        abort(403, 'User does not have any of the necessary access rights.');
    }

    if ($commission->status === 'approved' && $commission->payment_status === 'paid') {
    $commission->status = 'ready';
    $commission->save();
    return back()->with('success', 'Commission marked as ready.');
} else {
    return back()->with('error', 'Only paid and approved commissions can be marked as ready.');
}


}

public function markDelivered($id)
{
    $commission = CommissionRequest::findOrFail($id);

    if ($commission->artist_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    if ($commission->status === 'ready' && $commission->payment_status === 'paid') {
    $commission->status = 'delivered';
    $commission->save();
    return back()->with('success', 'Commission marked as delivered.');
} else {
    return back()->with('error', 'Only ready and paid commissions can be marked as delivered.');
}


}



public function respond(Request $request, $id)
{
    $commission = CommissionRequest::findOrFail($id);

    if ($commission->artist_id != Auth::id()) {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:approved,rejected', 
    ]);

    $commission->status = $request->input('status');
    $commission->save();

    // Send email if rejected
    if ($commission->status === 'rejected') {
        Mail::to($commission->customer->email)->send(new CommissionRejected($commission));
    }

    return back()->with('success', 'Response recorded.');
}

public function markAsPaid($id)
{
    $commission = CommissionRequest::findOrFail($id);

    // Ensure only the rightful customer can mark this
    if ($commission->customer_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    if ($commission->payment_status === 'unpaid' && $commission->status === 'approved') {
        $commission->payment_status = 'paid';
        $commission->save();

        return back()->with('success', 'Payment completed');
    }

    return back()->with('error', 'This commission cannot be paid for.');
}


public function customerRequests()
{
    $commissions = CommissionRequest::where('customer_id', Auth::id())->get();
    return view('commissions.customer', compact('commissions'));
}

public function setPriceAndApprove(Request $request, $id)
{
    $request->validate([
        'price' => 'required|numeric|min:0',
    ]);

    $commission = CommissionRequest::findOrFail($id);
    $commission->price = $request->price;
    $commission->status = 'approved';
    $commission->payment_status = 'unpaid';
    $commission->save();

    return redirect()->route('commissions.index')->with('success', 'Commission approved with price.');
}


}