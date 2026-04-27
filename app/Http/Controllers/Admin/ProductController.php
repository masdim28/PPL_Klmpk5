<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage; // Tambahkan ini
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->get(); 
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get(); 
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name'           => 'required',
        'price'          => 'required|numeric',
        'stock'          => 'required|numeric',
        'category_ids'   => 'required|array',
        'category_ids.*' => 'exists:categories,id',
        'images'         => 'required|array|min:1|max:5',
        'images.*'       => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    // 1. Buat Produk Dasar TANPA category_id
    $product = Product::create([
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock,
        'status'      => $request->status,
        // Hapus baris 'category_id' di sini karena kolomnya tidak ada di database
    ]);

    // 2. Simpan Relasi Kategori (Many-to-Many) ke tabel perantara
    $product->categories()->attach($request->category_ids);

    // 3. Simpan Banyak Gambar (Logika tetap sama)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('products', 'public');
            if ($index === 0) {
                $product->update(['image' => $path]);
            }
            $product->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Produk dan galeri berhasil ditambahkan');
}

    public function edit($id)
    {
        // Sertakan relasi images agar bisa dilihat di form edit
        $product = Product::with(['categories', 'images'])->findOrFail($id);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name'         => 'required',
        'price'        => 'required|numeric',
        'stock'        => 'required|numeric',
        'category_ids' => 'required|array',
        'images.*'     => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $product = Product::findOrFail($id);

    // 1. Update data dasar TANPA category_id
    $product->update([
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock,
        'status'      => $request->status,
        // HAPUS BARIS 'category_id' => $request->category_ids[0], DI SINI!
    ]);

    // 2. Sinkronisasi Kategori (Many-to-Many)
    // Ini akan otomatis mengupdate tabel perantara 'category_product'
    $product->categories()->sync($request->category_ids);

    // 3. Logika update gambar (tetap seperti kode Anda sebelumnya)
    if ($request->hasFile('images')) {
        foreach ($product->images as $oldImage) {
            Storage::disk('public')->delete($oldImage->image_path);
        }
        $product->images()->delete();

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('products', 'public');
            if ($index === 0) {
                $product->update(['image' => $path]);
            }
            $product->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
}
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        // Hapus semua file gambar fisik dari storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        // Relasi product_images akan terhapus otomatis jika Anda pakai onDelete('cascade') di migrasi
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function show($id)
    {
        // Load categories dan images untuk ditampilkan di halaman detail
        $product = Product::with(['categories', 'images'])->findOrFail($id);
        return view('admin.products.detail', compact('product'));
    }
}