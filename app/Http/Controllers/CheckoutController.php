<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\CommissionRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmationMail;

use App\Models\Cart;

class CheckoutController extends Controller
{
    // For handling commission payment
    public function commissionCheckout($commissionId)
    {
        // Find the commission request
        $commission = CommissionRequest::findOrFail($commissionId);

        // Ensure the commission is approved and unpaid
        if ($commission->status !== 'approved' || $commission->payment_status === 'paid') {
            return redirect()->route('commissions.index')->with('error', 'Commission is not eligible for payment.');
        }

        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Define the amount to charge (example is $10, you can replace this logic based on commission pricing)
        $amount = $commission->price * 100; // Amount in cents

        // Create Stripe Checkout session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $commission->title,
                            'description' => $commission->description,
                        ],
                        'unit_amount' => $amount, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('checkout.commissionSuccess', ['commissionId' => $commission->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('commissions.index'),
        ]);

        // Redirect to Stripe Checkout page
        return redirect($checkoutSession->url);
    }

    // Handle Stripe success callback for commission payment
    public function commissionSuccess(Request $request, $commissionId)
    {
        // Retrieve Stripe session using the session_id
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if (!$session) {
            return redirect()->route('commissions.index')->with('error', 'Payment failed.');
        }

        // Find the commission request
        $commission = CommissionRequest::findOrFail($commissionId);

        // Ensure the commission is approved and not already paid
        if ($commission->status !== 'approved') {
            return redirect()->route('commissions.index')->with('error', 'Commission not approved.');
        }

        // Update the commission payment status to 'paid' if the payment was successful
        if ($session->payment_status === 'paid') {
            $commission->payment_status = 'paid';
            $commission->save();

            // Send email to the artist notifying that the commission has been paid
            //$artist = $commission->artist;
            //Mail::to($artist->email)->send(new CommissionPaid($commission));

            // Send email to the customer notifying that the commission is ready
            //Mail::to($commission->customer->email)->send(new CommissionReady($commission));

            return view('checkout.success', [
                'commission' => $commission,
                'price' => $commission->price, // Add the price to the view data
            ]);
        }

        return redirect()->route('commissions.index')->with('error', 'Payment failed.');
    }

    public function checkout(Request $request)
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];

        foreach ($cart->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => optional($item->product)->name ?? 'Unknown Product',
                        'description' => optional($item->product)->description ?? 'No description',
                    ],
                    'unit_amount' => ($item->product->price ?? 0) * 100, // Avoid null crash
                ],
                'quantity' => $item->quantity,
            ];
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        // Retrieve Stripe session using the session_id
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::retrieve($request->session_id);

        if (!$session) {
            return redirect()->route('cart.index')->with('error', 'Payment failed.');
        }

        // Create order based on session
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart not found.');
        }

        // Create the order in the database
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'paid',
            'total_price' => $session->amount_total / 100,
            'payment_intent_id' => $session->payment_intent,
        'name' => session('checkout_name'),
    'email' => session('checkout_email'),
    'phone' => session('checkout_phone'),
    'address' => session('checkout_address'),
]);

        // Create order items based on cart items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Send order confirmation email
        Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

        // Clear cart after successful order
        $cart->items()->delete();
        $cart->delete();

        // Return success view
        return view('checkout.success', [
            'session' => $session, // Pass session info to the view
            'order' => $order, // Pass order info as well
        ]);
    }

    // Show the form
public function showForm()
{
    return view('checkout.form');
}

// Handle form submission and proceed to Stripe checkout
public function handleForm(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
    ]);

    // Store form data in session temporarily
    session([
        'checkout_name' => $request->name,
        'checkout_email' => $request->email,
        'checkout_phone' => $request->phone,
        'checkout_address' => $request->address,
    ]);

    return redirect()->route('checkout'); // This goes to the Stripe session setup
}

} 