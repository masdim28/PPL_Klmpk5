<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Mengambil data keranjang beserta produk dan variannya (warna & ukuran)
        $cart = Cart::with(['items.product', 'items.variant'])->where('user_id', Auth::id())->first();
        return view('cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $variantId = $request->input('product_variant_id');

        if ($product->status === 'sold_out') {
            return redirect()->back()->with('error', 'Maaf, produk ini sudah habis.');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id() 
        ]);

        // Cek apakah produk dengan varian yang sama sudah ada di keranjang
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($item) {
            $item->qty += 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'product_variant_id' => $variantId,
                'qty' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambah!');
    }

    /**
     * FUNGSI UNTUK MENGHAPUS ITEM (INI YANG TADI KURANG)
     */
    public function remove($id)
    {
        // Mencari item berdasarkan ID yang dikirim dari tombol hapus
        $item = CartItem::findOrFail($id);

        // Menghapus data dari database
        $item->delete();

        // Kembali ke halaman keranjang
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}