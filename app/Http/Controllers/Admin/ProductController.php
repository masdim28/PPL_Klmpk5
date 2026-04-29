<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant; // Import Model Varian
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'variants'])->latest()->get(); 
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
            'images.*'       => 'image|mimes:jpeg,png,jpg|max:2048',
            // Validasi Varian
            'variants'       => 'nullable|array',
            'variants.*.color' => 'nullable|string',
            'variants.*.size'  => 'nullable|string',
            'variants.*.stock' => 'required|numeric|min:0',
        ]);

        // 1. Buat Produk Utama
        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'status'      => $request->status,
        ]);

        // 2. Simpan Relasi Kategori
        $product->categories()->attach($request->category_ids);

        // 3. Simpan Varian Produk (Warna, Ukuran, Stok per Varian)
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                // Hanya simpan jika stok diisi
                $product->variants()->create([
                    'color' => $variant['color'] ?? '-',
                    'size'  => $variant['size'] ?? '-',
                    'stock' => $variant['stock'],
                ]);
            }
        }

        // 4. Simpan Gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                if ($index === 0) {
                    $product->update(['image' => $path]);
                }
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk dan varian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::with(['categories', 'images', 'variants'])->findOrFail($id);
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
        'images.*'     => 'image|mimes:jpeg,png,jpg|max:2048',
        'variants'     => 'nullable|array',
        'variants.*.stock' => 'required|numeric|min:0',
    ]);

    $product = Product::findOrFail($id);

    // 1. Update data dasar produk
    $product->update([
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock,
        'status'      => $request->status,
    ]);

    // 2. Sinkronisasi Kategori
    $product->categories()->sync($request->category_ids);

    // 3. Update Varian Produk
    if ($request->has('variants')) {
        // Ambil semua ID varian yang datang dari form
        $incomingVariantIds = collect($request->variants)->pluck('id')->filter()->toArray();

        // Hapus varian di database yang TIDAK ADA dalam kiriman form (user klik tombol hapus di UI)
        $product->variants()->whereNotIn('id', $incomingVariantIds)->delete();

        foreach ($request->variants as $variantData) {
            // Jika ada ID, berarti update varian yang sudah ada
            if (isset($variantData['id']) && !empty($variantData['id'])) {
                $product->variants()->where('id', $variantData['id'])->update([
                    'color' => $variantData['color'] ?? '-',
                    'size'  => $variantData['size'] ?? '-',
                    'stock' => $variantData['stock'],
                ]);
            } else {
                // Jika tidak ada ID, berarti ini baris varian baru yang ditambahkan user
                $product->variants()->create([
                    'color' => $variantData['color'] ?? '-',
                    'size'  => $variantData['size'] ?? '-',
                    'stock' => $variantData['stock'],
                ]);
            }
        }
    } else {
        // Jika input variants kosong sama sekali, hapus semua varian produk ini
        $product->variants()->delete();
    }

    // 4. Update gambar (Hanya jika ada file baru yang diupload)
    if ($request->hasFile('images')) {
        // Hapus gambar lama dari storage dan database
        foreach ($product->images as $oldImage) {
            Storage::disk('public')->delete($oldImage->image_path);
        }
        $product->images()->delete();

        // Simpan gambar baru
        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('products', 'public');
            if ($index === 0) {
                $product->update(['image' => $path]);
            }
            $product->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Koleksi Ade Afwa berhasil diperbarui');
}

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete(); // Ini juga akan menghapus varian jika cascade delete aktif

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function show($id)
    {
        $product = Product::with(['categories', 'images', 'variants'])->findOrFail($id);
        return view('admin.products.detail', compact('product'));
    }
}