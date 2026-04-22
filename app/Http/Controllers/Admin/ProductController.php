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
            'images'         => 'required|array|min:1|max:5', // Validasi minimal 1, maksimal 5
            'images.*'       => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 1. Buat Produk Dasar
        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'category_id' => $request->category_ids[0], 
        ]);

        // 2. Simpan Relasi Kategori (Many-to-Many)
        $product->categories()->attach($request->category_ids);

        // 3. Simpan Banyak Gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');

                // Gambar pertama (index 0) disimpan sebagai thumbnail utama di tabel products
                if ($index === 0) {
                    $product->update(['image' => $path]);
                }

                // Simpan semua gambar ke tabel product_images
                $product->images()->create([
                    'image_path' => $path
                ]);
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

        // Update data dasar
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
            'category_id' => $request->category_ids[0],
        ]);

        // Sync Kategori
        $product->categories()->sync($request->category_ids);

        // Jika ada unggahan gambar baru
        if ($request->hasFile('images')) {
            // Opsional: Hapus gambar lama jika ingin mengganti total
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
            $product->images()->delete();

            // Simpan gambar-gambar baru
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