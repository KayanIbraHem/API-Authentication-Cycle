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
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $products = Product::with(['category'])->get();
        return view('Dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
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
    public function update(ProductUpdateRequest $request, $id)
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
        $product = Product::find($id);
        if ($product->image != '') {
            File::deleteDirectory(public_path('product/' . $product->id),);
        }

        if ($product->delete()) {
            return redirect()->route('product.index')->with('success', 'تم الحذف');
        }
        return redirect()->back()->with('error', 'يوجد خطأ ما');
    }
}
