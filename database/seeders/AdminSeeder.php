<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // check permissions exist
        $superAdminRole = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'admin')->first();
        //permissionsnm
        $viewPermission = Permission::where('name', 'view books')->where('guard_name', 'admin')->first();
        $createPermission = Permission::where('name', 'create books')->where('guard_name', 'admin')->first();
        $updatePermission = Permission::where('name', 'update books')->where('guard_name', 'admin')->first();
        $deletePermission = Permission::where('name', 'delete books')->where('guard_name', 'admin')->first();
        if (!$superAdminRole || !$adminRole || !$viewPermission || !$createPermission || !$updatePermission || !$deletePermission) {
            $this->command->error('Roles or permissions not found. Please run migrations first.');
            return;
        }
        //Super Admin
        $superAdmin = Admin::firstOrCreate([
            'email' => 'superadmin@gmail.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('12345678')
        ]);
        $superAdmin->assignRole($superAdminRole);
        //Admin with Create Permission
        $adminCreate = Admin::firstOrCreate([
            'email' => 'admin_create@gmail.com'
        ], [
            'name' => 'Admin Create',
            'password' => bcrypt('12345678')
        ]);
        $adminCreate->assignRole($adminRole);
        $adminCreate->givePermissionTo($createPermission);

        //Admin with Update Permission
        $adminUpdate = Admin::firstOrCreate([
            'email' => 'admin_update@gmail.com'
        ], [
            'name' => 'Admin Update',
            'password' => bcrypt('12345678')
        ]);
        $adminUpdate->assignRole($adminRole);
        $adminUpdate->givePermissionTo($updatePermission);

        //Admin with Delete Permission
        $adminDelete = Admin::firstOrCreate([
            'email' => 'admin_delete@gmail.com'
        ], [
            'name' => 'Admin Delete',
            'password' => bcrypt('12345678')
        ]);
        $adminDelete->assignRole($adminRole);
        $adminDelete->givePermissionTo($deletePermission);
    }
}
