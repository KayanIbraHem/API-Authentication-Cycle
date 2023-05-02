<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
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
        return $this->belongsTo(Category::class,'maincat_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

}
