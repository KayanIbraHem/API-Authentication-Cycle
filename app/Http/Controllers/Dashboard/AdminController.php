<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\Admin\AdminStoreRequest;
use App\Http\Requests\Dashboard\Admin\AdminUpdateRequest;


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

    public function store(AdminStoreRequest $request)
    {
        $data = $request->except(['_token', 'password', 'hidden']);
        $data['password'] = Hash::make($request->password);
        $admin = Admin::create($data);
        if ($request->hasfile('image')) {
            $admin['image'] = 'images/' . UploadFiles::uploadImage($request['image']);
            $admin->update();
        }
        return redirect()->route('admin.create');
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        $admin = Admin::find($id);
        $data = $request->except(['_token', 'password', 'hidden']);
        if ( $request->password!='') {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasfile('image')) {
            if ($admin->image != '') {
                unlink(public_path($admin->image));
            }
            $data['image'] = 'images/' . UploadFiles::uploadImage($request['image']);
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
