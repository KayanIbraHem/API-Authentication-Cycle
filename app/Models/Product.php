<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'maincat_id',
        'subcat_id',
        'subsub_cat',
        'size_id',
        'image',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'maincat_id', 'id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    // public function productSizes() //Not used anymore
    // {
    //     return $this->sizes()
    //         ->join('sizes', 'product_price.size_id', '=', 'sizes.id')
    //         ->select('sizes.name', 'product_price.price', 'product_price.id');
    // }

    // public  function getSizeNamesAttribute()
    // {
    //     return $this->productSizes;
    // }

}
