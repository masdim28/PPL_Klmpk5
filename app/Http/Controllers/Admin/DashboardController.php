<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar
        $totalProduk = Product::count(); //
        
        // Menghitung produk berdasarkan kolom 'status' di database
        $readyStockCount = Product::where('status', 'ready')->count(); 
        
        // PERBAIKAN: Gunakan 'sold_out' sesuai yang tertulis di phpMyAdmin Anda
$soldOutCount = Product::where('status', 'sold_out')->count();
        
        // Menghitung total user dengan role 'user' atau 'customer'
        $totalUser = User::where('role', 'user')->count();

        // Statistik Pesanan & Pendapatan
        $pesananMasuk = Order::where('status_payment', 'pending')->count();
        $totalRevenue = Order::where('status_payment', 'paid')->sum('total_price');

        // 2. Data Grafik Penjualan (Bulan berjalan)
        $salesData = Order::where('status_payment', 'paid')
            ->select(DB::raw("SUM(total_price) as total"), DB::raw("MONTHNAME(created_at) as month"))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        // 3. Produk Terpopuler
        $mostClicked = Product::orderBy('clicks', 'desc')->take(3)->get();

        $topCheckout = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.image', DB::raw('SUM(order_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        //
        return view('admin.index', compact(
            'totalProduk', 'readyStockCount', 'soldOutCount', 
            'totalUser', 'pesananMasuk', 'totalRevenue',
            'mostClicked', 'topCheckout', 'salesData'
        ));
    }
}