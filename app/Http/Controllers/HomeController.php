<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman Home Utama
    public function index()
{
    // Mengambil kategori utama (Parent)
    $categoriesWithProducts = Category::whereNull('parent_id')
        ->get()
        ->map(function ($category) {
            // Ambil ID kategori ini dan semua ID sub-kategorinya
            $categoryIds = $category->children->pluck('id')->toArray();
            $categoryIds[] = $category->id;

            // Ambil 4 produk terbaru dari kategori utama ATAU sub-kategorinya
            $category->setRelation('products', 
                Product::whereIn('category_id', $categoryIds)
                    ->latest()
                    ->take(4)
                    ->get()
            );

            return $category;
        })
        // Filter agar kategori yang benar-benar tidak punya produk (dan sub-nya juga kosong) tidak muncul
        ->filter(function ($category) {
            return $category->products->count() > 0;
        });

    return view('home', compact('categoriesWithProducts'));
}

    // Fungsi saat kategori di klik
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Ambil ID kategori dan semua anaknya (sub-kategori)
        $categoryIds = $category->children->pluck('id')->toArray();
        $categoryIds[] = $category->id;

        // Ambil produk berdasarkan kategori tersebut
        $products = Product::whereIn('category_id', $categoryIds)->latest()->get();

        // Kirim data ke view yang sama (home.blade.php)
        return view('home', [
            'products' => $products,
            'currentCategory' => $category
        ]);
    }

    public function products()
    {
        $products = Product::latest()->get();
        return view('products', compact('products'));
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('detail', compact('product'));
    }
}