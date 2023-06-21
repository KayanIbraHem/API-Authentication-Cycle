<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;

class SubSubCategoryController extends Controller
{
    public function index()
    {
        $subsubcategories = Category::withCount('products')->get();
        return view('Dashboard.categories.sbusubcategory.index', compact('subsubcategories'));
    }
    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')->get();
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
        $subSubCat = Category::where('id', $id)->firstorfail();
        return view('Dashboard.categories.sbusubcategory.edit', compact('subSubCat', 'categories'));
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $subSubCat = Category::find($id);
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            if ($subSubCat->image != '') {
                File::deleteDirectory(public_path('category/' . $subSubCat->id),);
            }
            $data['image'] = 'category/' . $subSubCat->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $subSubCat->id, 'category/');
        }
        $subSubCat->update($data);
        return redirect()->route('category.subsub.index');
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
