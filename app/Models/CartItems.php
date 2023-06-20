<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItems extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = ['cart_id', 'user_id', 'product_id', 'size_id', 'quantity', 'price', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ProductSizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
