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
        $mainCategories = Category::all();

        return view('Dashboard.categories.index', compact('mainCategories'));
    }

    public function create()
    {
        $mainCategories = Category::where('parent_id', 0)->get();
        return view('Dashboard.categories.create', compact('mainCategories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        if ($request->hasfile('image')) {
            $category['image'] = 'category/' . $category->id . '/' . UploadFiles::uploadImageWithFolder($request['image'], $category->id, 'category/');
            $category->update();
        }
        return redirect()->route('category.create');
    }

    public function edit($id)
    {
        $mainCategories = Category::where('parent_id', 0)->get();
        $category = Category::where('id', $id)->withCount('subcategories')->firstorfail();
        return view('Dashboard.categories.edit', compact('category', 'mainCategories'));
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
        return redirect()->route('category.index');
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
