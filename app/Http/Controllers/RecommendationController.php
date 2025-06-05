<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaction;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function getInteractions()
    {
        return response()->json(Interaction::all());
    }

    public function getProducts()
    {
        return response()->json(Product::all());
    }
    

public function getRecommendations($user_id)
{
    $response = Http::get("http://127.0.0.1:9000/recommend/$user_id");

    if ($response->successful()) {
        return response()->json($response->json());
    }

    return response()->json(['message' => 'Error fetching recommendations'], 500);
}

public function storeInteraction(Request $request)
{
    // Validate incoming data
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'product_id' => 'required|integer|exists:products,id',
        'interaction' => 'required|integer',
    ]);

    // Create a new interaction
    $interaction = Interaction::create($validated);

    // Return response
    return response()->json($interaction, 201);  // 201 Created
}


}
