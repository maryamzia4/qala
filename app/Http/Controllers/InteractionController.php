<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    // Display all interactions (for testing or debug purposes)
    public function index()
    {
        return response()->json(Interaction::all());
    }

    // Store new interaction with computed interaction value based on user action
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'action' => 'required|string'  // Action (click, view, purchase)
        ]);

        // Calculate the interaction value based on the action
        $interaction_value = $this->calculateInteraction($request->action);

        // Create and store the interaction with the calculated value
        $interaction = Interaction::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'interaction' => $interaction_value
        ]);

        // Return the created interaction response
        return response()->json($interaction, 201);
    }

    // Calculate interaction value based on the action type
    private function calculateInteraction($action)
    {
        // Define interaction values based on user action
        switch (strtolower($action)) {
            case 'click':
                return 1; // Click on product = 1
            case 'view':
                return 0.5; // View on product = 0.5
            case 'add_to_cart':
                return 5; // add to cart = 5 
            default:
                return 0; 
        }
    }
}
