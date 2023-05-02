<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function showAllProduct()
    {
        $products = Product::get();
        return  new ProductCollection($products);
    }

    public function showProductByCategory($category)
    {
        $products = Product::where('maincat_id', $category)->paginate(5);
        return   new ProductCollection($products);
    }

    public function searchByName(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")
            ->orwhere('description', 'like', "%$search%")
            ->orderBy('size_id')
            ->get();

        // $search = $request->input('search');

        // $products = Product::join('products', 'sizes.id', '=', 'products.size_id')

        //     ->where('name', 'like', "%$search%")

        //     ->orwhere('description', 'like', "%$search%")

        //     // ->orderBy('price')
        //     // ->select('products.*')
        //     ->get();
        return new ProductCollection($products);
    }
}


