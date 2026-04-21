<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk di halaman admin.
     */
    public function index()
    {
        // Tetap sama: Mengambil produk terbaru beserta data kategorinya
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Tampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        // OPTIMASI: Ambil kategori utama (parent) beserta anak-anaknya (children)
        // agar di form dropdown bisa kita tampilkan secara hierarkis
        $categories = Category::whereNull('parent_id')->with('children')->get(); 
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Tambahkan validasi exists
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public'); 

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Tampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // OPTIMASI: Gunakan hierarki yang sama untuk edit
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            // REKOMENDASI: Aktifkan hapus gambar lama agar storage AWS EC2 kamu tidak penuh
            if($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // REKOMENDASI: Aktifkan hapus file agar storage tetap bersih
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}