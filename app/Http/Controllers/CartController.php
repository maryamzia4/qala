<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to cart
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()]  // Create a new cart if it doesn't exist
        );

        // Check if the product is already in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            // If product exists, update the quantity
            $cartItem->increment('quantity');
        } else {
            // Otherwise, add it to the cart
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Display the cart
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        return view('cart.index', compact('cart'));
    }

    // Remove product from cart
    public function removeFromCart($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    // Update product quantity
    public function updateCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cart = Cart::where('user_id', Auth::id())->first();
    $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();

    if ($cartItem) {
        $cartItem->update(['quantity' => $request->quantity]);
    }

    return redirect()->route('cart.index')->with('success', 'Cart updated!');
}

public function clearCart()
{
    $cart = Cart::where('user_id', Auth::id())->first();
    if ($cart) {
        $cart->items()->delete();
    }

    return redirect()->route('cart.index')->with('success', 'Cart cleared!');
}

    
}
