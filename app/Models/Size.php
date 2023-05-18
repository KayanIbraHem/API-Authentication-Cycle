<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'sizes';

    protected $fillable=[
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_price')->withPivot('price');
    }

    // public function getProduct()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
