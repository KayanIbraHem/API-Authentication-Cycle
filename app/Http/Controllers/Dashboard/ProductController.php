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
use App\Models\ProductSize;

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
        $request = request();
        $query = Product::query();
        if ($name = $request->query('name')) {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        $products = $query->with(['sizes', 'category'])->get();
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
        $categories = Category::where('parent_id', null)->get();
        $product = Product::where('id', $id)->firstorfail();
        $sizes = Size::all();

        return view('Dashboard.products.edit', compact('product', 'categories', 'sizes'));
    }
    public function update(ProductUpdateRequest $request, $id)
    {
        // dd($request);
        $product = Product::find($id);
        $data = $request->except('_token', 'size_id', 'price');
        if ($request->hasFile('image')) {
            if ($product->image != '') {
                File::deleteDirectory(public_path('product/' . $product->id),);
            }
            $data['image'] = 'product/' . $product->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $product->id, 'product/');
        }
        $product->update($data);
        $dataList = $request->data_list;
        // if ($dataList[1]['price'] != null) {
        if ($dataList) {
            foreach ($dataList as $d) {
                if ($d['price'] != null) {
                    $product->sizes()->create(['product_id' => $product->id, 'size_id' => $d['size_id'], 'price' => $d['price']]);
                }
            }
        }
        // }
        return redirect()->route('product.index');
    }

    public function store(ProductStoreRequest $request)
    {
        // dd($request->all());
        $data = $request->except('_token', 'price', 'size_id');
        $product = Product::create($request->validated());
        if ($request->data_list) {
            $dataList = $request->data_list;
            // $productSize=new ProductSize();
            foreach ($dataList as $d) {
                $product->sizes()->create(['product_id' => $product->id, 'size_id' => $d['size_id'], 'price' => $d['price']]);
                // $product->sizes()->attach($d['size_id'], ['price' => $d['price']]);
            }
        }
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

    // public function editSizePrice($id, $size)
    // {
    //     $productSize = ProductSize::where('size_id', $size)->first();
    //     $sizes = Size::all();

    //     return view('Dashboard.products.editsize', compact('productSize', 'sizes'));
    // }
}
