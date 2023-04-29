<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Dashboard\Product\ProductStoreRequest;
use App\Http\Requests\Dashboard\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category'])->get();
        return view('Dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        $sizes = Size::all();
        return view('Dashboard.products.create', compact('categories', 'sizes'));
    }
    public function edit($id)
    {
        $categories = Category::where('parent_id', 0)->get();
        $product = Product::where('id', $id)->firstorfail();
        $sizes = Size::all();

        return view('Dashboard.products.edit', compact('product', 'categories', 'sizes'));
    }
    public function update(ProductUpdateRequest $request,$id)
    {
        $product = Product::find($id);
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            if ($product->image != '') {
                File::deleteDirectory(public_path('product/' . $product->id),);
            }
            $data['image'] = 'product/' . $product->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $product->id, 'product/');
        }
        $product->update($data);
        return redirect()->route('product.index');
    }
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            if ($request->image != '') {
                File::deleteDirectory(public_path('product/' . $product->id),);
            }
            $data['image'] = 'product/' . $product->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $product->id, 'product/');
        }
        $product->update($data);
        return redirect()->route('product.index');
    }
    public function delete($id)
    {
    }
}
