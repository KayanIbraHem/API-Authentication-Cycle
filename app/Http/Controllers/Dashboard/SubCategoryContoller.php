<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;

class SubCategoryContoller extends Controller
{
    public function index()
    {

        $allcategories = Category::whereNull('parent_id')->get();
        return view('Dashboard.categories.subcategory.index', compact('allcategories'));
    }

    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('Dashboard.categories.subcategory.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        if ($request->hasfile('image')) {
            $category['image'] = 'category/' . $category->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $category->id, 'category/');
            $category->update();
        }
        return redirect()->route('category.subcategory.index');
    }

    public function edit($id)
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        $subSubCat = Category::where('id', $id)->firstorfail();
        return view('Dashboard.categories.subcategory.edit', compact('subSubCat', 'mainCategories'));
    }

    public function update(Request $request, $id)
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
        return redirect()->route('category.subcategory.index');
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if ($category->subSubCategories->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete subcategory with sub-subcategories.');
        }
        if ($category->image != '') {
            File::deleteDirectory(public_path('category/' . $category->id),);
        }

        if ($category->delete()) {
            return redirect()->route('category.subcategory.index')->with('delete', 'تم حذف القسم');
        }
        return redirect()->back()->with('error', 'يوجد خطأ ما');
    }
}
