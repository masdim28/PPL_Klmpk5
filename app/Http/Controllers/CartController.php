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
        // Mengambil data cart milik user yang sedang login beserta item dan produknya (Eager Loading)
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        return view('cart', compact('cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        // PERBAIKAN: Gunakan Auth::id() agar keranjang sesuai dengan user yang login
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