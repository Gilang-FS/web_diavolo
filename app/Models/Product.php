<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
    'category_id','name','slug','description',
    'price','discount_price','stock','image','sizes','sold','status'
    ];

    protected $casts = [
    'price' => 'decimal:2',
    'discount_price' => 'decimal:2',
    'sizes' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Harga aktif (pakai discount_price kalau ada)
    public function getActivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Format harga ke Rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->active_price, 0, ',', '.');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}