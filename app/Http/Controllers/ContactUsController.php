<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function send(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Send the email to admin
        //Mail::to('mrmzia04@gmail.com') // Replace with admin email
            Mail::to('maryamchaudary4@gmail.com')->send(
    new ContactUsMail($request->name, $request->email, $request->message)
);


        // Redirect or return response
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
