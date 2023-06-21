<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $mainCategories = Category::withCount('subcategories')->whereNull('parent_id')->get();
        // $mainCategories = Category::all();

        return view('Dashboard.categories.maincategory.index', compact('mainCategories'));
    }

    public function create()
    {
        return view('Dashboard.categories.maincategory.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        if ($request->hasfile('image')) {
            $category['image'] = 'category/' . $category->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $category->id, 'category/');
            $category->update();
        }
        return redirect()->route('category.index')->with('store', 'تم اضافة القسم بنجاح');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->firstorfail();
        return view('Dashboard.categories.maincategory.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            if ($category->image != '') {
                File::deleteDirectory(public_path('category/' . $category->id),);
            }
            $data['image'] = 'category/' . $category->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $category->id, 'category/');
        }
        $category->update($data);
        return redirect()->route('category.index')->with('update', 'تم تعديل القسم بنجاح');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->image != '') {
            File::deleteDirectory(public_path('category/' . $category->id),);
        }

        if ($category->delete()) {
            return redirect()->route('category.index')->with('delete', 'تم حذف القسم');
        }
        return redirect()->back()->with('error', 'يوجد خطأ ما');
    }

    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }

    public function getSubsubcategories($id)
    {
        $subsubcategories  = Category::where('parent_id', $id)->get();
        return response()->json($subsubcategories);
    }
}
