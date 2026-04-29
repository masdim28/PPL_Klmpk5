<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $selectedIds = $request->input('selected_items');

        if (!$selectedIds) {
            return redirect()->route('cart.index')->with('error', 'Silahkan pilih barang terlebih dahulu!');
        }

        $items = CartItem::whereIn('id', $selectedIds)
                    ->whereHas('cart', function($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->with(['product', 'variant']) // PERBAIKAN: Dari 'product_variant' menjadi 'variant'
                    ->get();

        $total = $items->sum(function($item) {
            return $item->product->price * $item->qty;
        });

        return view('checkout', compact('items', 'total', 'selectedIds'));
    }

    public function process(Request $request)
    {
        $selectedIds = $request->input('selected_items');
        
        // Load data dengan relasi varian dan produk
        $items = CartItem::whereIn('id', $selectedIds)->with(['product', 'variant'])->get(); // PERBAIKAN: Menjadi 'variant'

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan, item tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            // 1. Validasi Stok
            foreach ($items as $item) {
                if ($item->product_variant_id) {
                    $variant = $item->variant; // PERBAIKAN: Menggunakan $item->variant
                    if (!$variant || $variant->stock < $item->qty) {
                        throw new \Exception("Stok varian {$item->product->name} ({$variant->color}/{$variant->size}) tidak mencukupi.");
                    }
                } else {
                    if ($item->product->stock < $item->qty) {
                        throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                    }
                }
            }

            // 2. Buat Header Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $items->sum(fn($i) => $i->product->price * $i->qty),
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // 3. Simpan Detail Order & Update Stok
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price
                ]);

                if ($item->product_variant_id) {
                    $variant = ProductVariant::find($item->product_variant_id);
                    $variant->decrement('stock', $item->qty);
                }

                $item->product->decrement('stock', $item->qty);
                
                if ($item->product->fresh()->stock <= 0) {
                    $item->product->update(['status' => 'sold_out']);
                }
            }

            // 4. Hapus barang dari keranjang
            CartItem::whereIn('id', $selectedIds)->delete();

            DB::commit();

            // 5. Susun Pesan WhatsApp
            $message = "Halo Admin, saya order di Ade Afwa Boutique:%0A";
            foreach ($items as $item) {
                // PERBAIKAN: Menggunakan $item->variant
                $variantInfo = $item->product_variant_id ? " [" . $item->variant->color . "/" . $item->variant->size . "]" : "";
                $message .= "- " . $item->product->name . $variantInfo . " (" . $item->qty . ")%0A";
            }
            $message .= "%0ATotal: Rp " . number_format($order->total_price, 0, ',', '.');
            $message .= "%0APembayaran: " . $request->payment_method;

            $phone = "088972042818";
            return redirect("https://wa.me/$phone?text=$message");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart.index')->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}