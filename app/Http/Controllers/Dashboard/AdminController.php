<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\Helpers\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
        $roles = Role::pluck('name', 'name')->all();
        return view('Dashboard.admins.create', compact('roles'));
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $adminRole = $admin->roles->pluck('name', 'name')->all();
        return view('Dashboard.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    public function store(AdminStoreRequest $request)
    {
        $data = $request->except(['_token', 'password', 'hidden']);
        $data['password'] = Hash::make($request->password);
        $admin = Admin::create($data);
        $admin->assignRole($request->input('roles'));
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
        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasfile('image')) {
            if ($admin->image != '') {
                unlink(public_path($admin->image));
            }
            $data['image'] = 'images/' . UploadFiles::uploadImage($request['image']);
        }
        $admin->update($data);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $admin->assignRole($request->input('roles'));

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
