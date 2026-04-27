<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Menu Transaksi
public function transaksi() {
    // Ubah 'unpaid' menjadi 'pending' sesuai database
    $orders = Order::where('status_payment', 'pending')->latest()->get();
    return view('admin.orders.transaksi', compact('orders'));
}

    public function konfirmasiPembayaran($id) {
        $order = Order::findOrFail($id);
        // Update menggunakan nama kolom di database kamu
        $order->update([
            'status_payment' => 'paid', 
            'status_shipping' => 'processing'
        ]);
        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }

   // 2. Menu Pesanan
public function pesanan() {
    // Sesuaikan logika jika Anda ingin menampilkan pesanan yang sudah dibayar
    // Atau jika ingin menampilkan yang masih pending, ubah status_payment-nya
    $orders = Order::where('status_payment', 'paid')
                  ->where('status_shipping', '!=', 'completed')
                  ->latest()->get();
    return view('admin.orders.pesanan', compact('orders'));
}

    public function updateResi(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->update([
            'note' => $request->resi, // Menggunakan kolom 'note' untuk sementara sebagai resi
            'status_shipping' => 'shipping'
        ]);
        return back()->with('success', 'Resi berhasil diinput!');
    }

    // 3. Menu Pesanan Berhasil
    public function selesai() {
        $orders = Order::where('status_shipping', 'completed')->latest()->get();
        return view('admin.orders.selesai', compact('orders'));
    }
}