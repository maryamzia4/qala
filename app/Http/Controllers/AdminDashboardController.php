<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ArtistProfile;
use App\Models\CommissionRequest;


use Carbon\Carbon; // Import Carbon for date manipulation

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count all users minus 1 admin
        $totalArtists = User::count() - 1; // Excluding the admin
        $totalProducts = Product::count();

        // New users in the last 24 hours
        $newUsersLast24Hours = User::where('created_at', '>=', Carbon::now()->subDay())->count();

        // Total Orders
        $totalOrders = Order::count();

        // Total Earnings
        //$totalEarnings = Order::sum('total_price');
$totalProductSales = DB::table('order_items')
    ->join('products', 'order_items.product_id', '=', 'products.id')
    ->select(DB::raw('SUM(order_items.quantity * order_items.price) as total'))
    ->value('total') ?? 0;

$totalCommissionSales = DB::table('commission_requests')
    ->whereIn('status', ['approved', 'ready', 'delivered'])
    ->where('payment_status', 'paid')
    ->sum('price') ?? 0;

$totalEarnings = $totalProductSales + $totalCommissionSales;


        // Average amount spent per order
        $averageAmountPerOrder = Order::avg('total_price');

        $monthlySales = DB::table('orders')
        ->select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw("SUM(total_price) as total")
        )
        ->where('status', 'paid')
        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))
        ->orderByRaw("MIN(created_at)")
        ->pluck('total', 'month')
        ->toArray();

        $totalRequests = DB::table('commission_requests')->count();
    
    $totalApproved = DB::table('commission_requests')
                    ->whereIn('status', ['approved', 'ready', 'delivered'])
                    ->count();

    $totalRejected = DB::table('commission_requests')->where('status', 'rejected')->count();
//dd($totalRequests, $totalApproved, $totalRejected);
        return view('admin.dashboard.index', compact(
            'totalArtists', 
            'totalProducts', 
            'newUsersLast24Hours', 
            'totalOrders', 
            'totalEarnings', 
            'averageAmountPerOrder',
            'monthlySales',
            'totalRequests',
            'totalApproved',
            'totalRejected',
            'totalProductSales',       
            'totalCommissionSales'
            
        ));

    }

    public function allArtists()
{
    $artists = User::whereHas('artistProfile')
    ->where('role', '!=', 'admin')
    ->with(['artistProfile', 'products'])
    ->get();

    $artistsData = $artists->map(function ($artist) {
        $totalProducts = $artist->products->count();

        $orderItemDetails = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $artist->id)
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as total_orders, SUM(order_items.quantity * order_items.price) as total_sales')
            ->first();

        return [
            'id' => $artist->id,
            'username' => optional($artist->artistProfile)->username ?? 'N/A',
            'email' => $artist->email,
            'total_products' => $totalProducts,
            'total_orders' => $orderItemDetails->total_orders ?? 0,
            'total_sales' => $orderItemDetails->total_sales ?? 0,
        ];
    });

    return view('admin.dashboard.all-artists', ['artists' => $artistsData]);
}

public function allProducts()
{
    $products = Product::with('user:id,name') // eager load user name only
        ->select('id', 'user_id', 'name', 'price', 'image')
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'artist_name' => $product->user->name ?? 'Unknown',
            ];
        });

    return view('admin.dashboard.all-products', compact('products'));
}



public function allCustomRequests()
{
    $commissions = CommissionRequest::with(['customer', 'artist'])->latest()->get();
    
    return view('admin.dashboard.custom', compact('commissions'));
}



}