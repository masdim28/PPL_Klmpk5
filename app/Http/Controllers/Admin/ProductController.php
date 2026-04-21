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
        // Mengambil produk terbaru beserta data kategori jamak (many-to-many)
        $products = Product::with('categories')->latest()->get(); 
        return view('admin.products.index', compact('products'));
    }

    /**
     * Tampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        // Mengambil kategori untuk ditampilkan di checkbox
        $categories = Category::whereNull('parent_id')->with('children')->get(); 
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
            'category_ids' => 'required|array', // Validasi array untuk banyak kategori
            'category_ids.*' => 'exists:categories,id',
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public'); 

        // 1. Buat Produk
        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'image'       => $imagePath,
            // Opsional: Simpan kategori pertama sebagai kategori utama di kolom lama
            'category_id' => $request->category_ids[0], 
        ]);

        // 2. Simpan hubungan Many-to-Many ke tabel pivot
        if ($request->has('category_ids')) {
            $product->categories()->attach($request->category_ids);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan ke berbagai kategori');
    }

    /**
     * Tampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        // Load produk beserta kategori yang sudah dipilih sebelumnya
        $product = Product::with('categories')->findOrFail($id);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
            'category_ids' => 'required|array'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        // 1. Update data dasar produk
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'category_id' => $request->category_ids[0], // Update kategori utama
            'image'       => $imagePath,
        ]);

        // 2. Sinkronisasi Kategori (Hapus yang lama, tambah yang baru dicentang)
        if ($request->has('category_ids')) {
            $product->categories()->sync($request->category_ids);
        }

        return redirect()->route('admin.products.index')->with('success', 'Data koleksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Menghapus hubungan di tabel pivot secara otomatis jika onDelete('cascade') aktif
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus dari sistem');
    }
   public function show($id)
{
    // Mengambil produk beserta kategori jamaknya agar bisa ditampilkan di detail
    $product = Product::with('categories')->findOrFail($id);
    return view('admin.products.detail', compact('product'));
}
}