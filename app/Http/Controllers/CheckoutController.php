<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
   public function index(Request $request)
{
    // Mengambil ID barang yang dicentang user
    $selectedIds = $request->input('selected_items');

    if (!$selectedIds) {
        return redirect()->route('cart.index')->with('error', 'Silahkan pilih barang terlebih dahulu!');
    }

    // Ambil data item keranjang yang dipilih saja
    $items = CartItem::whereIn('id', $selectedIds)
                ->whereHas('cart', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->with('product')
                ->get();

    // HITUNG TOTAL HARGA DI SINI
    $total = $items->sum(function($item) {
        return $item->product->price * $item->qty;
    });

    // Kirim variabel 'total' ke view
    return view('checkout', compact('items', 'total', 'selectedIds'));
}

    public function process(Request $request)
    {
        // Ambil kembali item yang dipilih berdasarkan input hidden di view checkout
        $selectedIds = $request->input('selected_items');
        
        $items = CartItem::whereIn('id', $selectedIds)->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan, item tidak ditemukan.');
        }

        // 1. Buat Header Order
        $order = Order::create([
            'user_id' => Auth::id(), // Menggunakan ID user yang login, bukan hardcode 1
            'total_price' => $items->sum(fn($i) => $i->product->price * $i->qty),
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // 2. Simpan Detail Order (OrderItem)
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price
            ]);
        }

        // 3. Susun Pesan WhatsApp
        $message = "Halo Admin, saya order:%0A";
        foreach ($items as $item) {
            $message .= "- " . $item->product->name . " (" . $item->qty . ")%0A";
        }
        $message .= "%0ATotal: Rp " . number_format($order->total_price, 0, ',', '.');
        $message .= "%0APembayaran: " . $request->payment_method;

        // 4. Hapus hanya barang yang dibeli dari keranjang
        CartItem::whereIn('id', $selectedIds)->delete();

        $phone = "088972042818";
        return redirect("https://wa.me/$phone?text=$message");
    }
}