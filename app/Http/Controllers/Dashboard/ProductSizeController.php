<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\ProductSizeUpdateRequest;
use App\Models\Product;

class ProductSizeController extends Controller
{

    public function edit($id)
    {
        $productSize = ProductSize::find($id);
        return view('Dashboard.products.editsize', compact('productSize'));
    }
    public function update(ProductSizeUpdateRequest $request,  $id)
    {
        $product = ProductSize::find($id);
        $data = $request->except('_token');
        $product->update($data);
        return redirect()->route('product.edit', $product->product_id);
    }

    public function delete(ProductSize $productSize)
    {
        if ($productSize->delete()) {
            return redirect()->back()->with('success', 'تم الحذف');
        }
        return redirect()->back()->with('error', 'يوجد خطأ ما');
    }
}
