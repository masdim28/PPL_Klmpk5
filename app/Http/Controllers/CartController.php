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
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return view('cart', compact('cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        // --- LOGIKA TAMBAHAN: CEK STATUS PRODUK ---
        // Jika status produk di database adalah sold_out, cegah penambahan
        if ($product->status === 'sold_out') {
            return redirect()->back()->with('error', 'Maaf, produk ini sudah habis dan tidak dapat ditambahkan ke keranjang.');
        }
        // ------------------------------------------

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id() 
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        if ($item) {
            $item->qty += 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'qty' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambah!');
    }
}