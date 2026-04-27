<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Category;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\ProductImage; // Pastikan ini diimport jika ada model ProductImage

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',   // Sudah ada untuk Ready/Sold Out
        'clicks',   // TAMBAHKAN INI: Agar error "Unknown column clicks" hilang
        'category_id',
        'image'
    ];

    /**
     * RELASI BARU: Satu produk bisa masuk ke banyak kategori (Many-to-Many)
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * RELASI LAMA: Menunjuk ke satu kategori utama saja (Optional)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}