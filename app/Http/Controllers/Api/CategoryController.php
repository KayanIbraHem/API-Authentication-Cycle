<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function showAllCateogry()
    {
        $categories = Category::with('subcategories')->get();
        // $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function subCategories($mainCategoryId)
    {

        $category = Category::where('parent_id', $mainCategoryId)->get();
        return new CategoryCollection($category);
    }

    public function subSubCategory($subCateoryId)
    {

        $category = Category::where('parent_id', $subCateoryId)->get();
        return response()->json($category);
    }
}
