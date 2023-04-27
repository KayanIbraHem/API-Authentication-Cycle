<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;

class SubSubCategoryController extends Controller
{
    public function index()
    {
        $subsubcategories = Category::all();
        return view('Dashboard.categories.sbusubcategory.index', compact('subsubcategories'));
    }
    public function create()
    {
        $mainCategories = Category::where('parent_id', 0)->get();
        return view('Dashboard.categories.sbusubcategory.create', compact('mainCategories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        if ($request->hasfile('image')) {
            $category['image'] = 'category/' . $category->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $category->id, 'category/');
            $category->update();
        }
        return redirect()->route('category.subsub.create');
    }

    public function edit($id)
    {
        $categories = Category::where('parent_id', 0)->get();
        $category = Category::where('id', $id)->firstorfail();
        return view('Dashboard.categories.sbusubcategory.edit', compact('category', 'categories'));
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->image != '') {
            File::deleteDirectory(public_path('category/' . $category->id),);
        }

        if ($category->delete()) {
            return redirect()->route('category.index')->with('success', 'تم الاضافة بنجاح');
        }
        return redirect()->back()->with('error', 'يوجد خطأ ما');
    }
}
