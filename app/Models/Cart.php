<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use Notifiable, HasFactory;

    protected $table = 'carts';

    // protected $fillable = ['user_id', 'product_id', 'size_id', 'quantity', 'price'];
    protected $fillable = ['order_number', 'user_id', 'coupon_id', 'status', 'city', 'address', 'payment_method', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(CartItems::class, 'cart_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    public function cartTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    public function totalWithDiscount()
    {
        $cartTotal = $this->cartTotal();
        $total =  $cartTotal - $this->discount;
        return $total;
    }
    protected static function booted()
    {
        static::creating(function (Cart $cart) {
            //20220001 , 20220002
            $cart->order_number = Cart::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Cart::whereYear('created_at', $year)->max('order_number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
