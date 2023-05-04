<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'Kayan',
            'email' => 'kayan@gmail.com',
            'password' => bcrypt('123123')
        ]);

        $role = Role::create(['name' => 'Admin','guard_name'=>'admin']);

        $permissions = Permission::pluck('id');

        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);
    }
}
