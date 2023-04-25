<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\UploadFiles;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Dashboard\AdminRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Dashboard.dashboard');
    }

    public function index()
    {
        $admins = Admin::all();
        return view('Dashboard.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('Dashboard.admins.create');
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('Dashboard.admins.edit', compact('admin'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->except(['_token', 'password', 'hidden']);
        $data['password'] = Hash::make($request->password);
        $admin = Admin::create($data);
        if ($request->hasfile('image')) {
            $admin['image'] = 'images/' . UploadFiles::uploadimage($request['image']);
            $admin->update();
        }
        return redirect()->route('admin.create');
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $data = $request->except(['_token', 'password', 'hidden']);
        if ($admin->password != $request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasfile('image')) {
            if ($admin->image != '') {
                unlink(public_path($admin->image));
            }
            $data['image'] = 'images/' . UploadFiles::uploadimage($request['image']);
        }
        $admin->update($data);

        return redirect()->route('admin.index');
    }
    public function delete($id)
    {
        $admin = Admin::find($id);
        if ($admin->image != '')
            unlink(public_path($admin->image));
        $admin->delete();
        return redirect()->route('admin.index');
    }
}
