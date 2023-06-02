<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_number', 'status', 'payment_method', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->hasone(OrderAddress::class, 'order_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            //20220001 , 20220002
            $order->order_number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('order_number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
