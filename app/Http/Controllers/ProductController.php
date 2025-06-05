<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Recommendation;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index(Request $request)
{
    $category = $request->category;
    $user = Auth::user();

    // Fetch recommendations from FastAPI
    $recommendations = $this->fetchRecommendations($user->id);

    // Store recommendations in the database
    $this->storeRecommendations($user->id, $recommendations);

    // Fetch recommended product IDs from the 'recommendations' table
    $recommendedProductIds = Recommendation::where('user_id', $user->id)
        ->orderByDesc('score')
        ->pluck('product_id')
        ->toArray();

    //$recommendedProducts = Product::whereIn('id', $recommendedProductIds)->get();
    $recommendedProducts = Product::whereIn('id', $recommendedProductIds)
    ->orderByRaw("FIELD(id, " . implode(',', $recommendedProductIds) . ")") // Preserve recommendation order
    ->take(3)
    ->get();

    // Log recommended products to ensure they're fetched
    \Log::debug('Recommended Products:', $recommendedProducts->toArray());


    // Get regular products (all or filtered by category)
    $products = $category
        ? Product::where('category', $category)->get()
        : Product::all();

    // Pass data to view
    return view('products.index', compact('products', 'recommendedProducts'));  // Ensure you're passing 'recommendedProducts'
}



public function storeRecommendations($userId, $recommendations)
{
    // Ensure recommendations is an array of arrays
    if (!is_array($recommendations) || !isset($recommendations[0]['id'])) {

        \Log::debug("Recommendations response was not a valid array", ['recommendations' => $recommendations]);
        return;
    }

    foreach ($recommendations as $recommendation) {
        Recommendation::create([
            'user_id' => $userId,
            'product_id' => $recommendation['id'], 
            'score' => $recommendation['score'] ?? 1, // Default score if not provided
        ]);
    }
}

    
    
private function fetchRecommendations($userId)
{
    $client = new Client();

    try {
        $response = $client->get("http://127.0.0.1:9000/recommend/{$userId}?top_n=3");

        $data = json_decode($response->getBody(), true);

        \Log::debug('FastAPI Response:', $data);

        // Correctly access the nested recommendations array
        return $data['recommendations']['recommendations'] ?? [];
    } catch (\Exception $e) {
        \Log::error('Error fetching recommendations:', ['error' => $e->getMessage()]);
        return [];
    }
}

    public function create()
    {
        $categories = [
            'calligraphy' => 'Calligraphy',
            'resin_art' => 'Resin Art',
            'abstract_art' => 'Abstract Art',
            'digital_art' => 'Digital Art',
            'painting' => 'Painting',
            'faceless_portraits' => 'Faceless Portraits',
            'landscape' => 'Landscape',
            'fabric_painting' => 'Fabric Painting',
        ];
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validateProduct($request);

        $product = new Product();
        $product->user_id = Auth::id();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = $request->category;

        if ($request->hasFile('image')) {
            $product->image = $this->uploadImage($request);
        }

        $product->save();

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $this->validateProduct($request);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = $request->category;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $this->uploadImage($request);
        }

        $product->save();

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('artist-profile.show', Auth::id())
            ->with('success', 'Product deleted successfully.');
    }

    protected function validateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    protected function uploadImage(Request $request)
    {
        return $request->file('image')->store('product_images', 'public');
    }
}
