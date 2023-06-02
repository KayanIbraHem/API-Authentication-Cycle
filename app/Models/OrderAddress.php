<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $table = 'order_addresses';

    protected $fillable = ['order_id', 'order_type', 'full_name', 'city', 'address'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
