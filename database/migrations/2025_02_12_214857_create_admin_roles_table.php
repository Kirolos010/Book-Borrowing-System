<?php
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        // Create permissions
        $viewPermission = Permission::create(['name' => 'view books', 'guard_name' => 'admin']);
        $createPermission = Permission::create(['name' => 'create books', 'guard_name' => 'admin']);
        $updatePermission = Permission::create(['name' => 'update books', 'guard_name' => 'admin']);
        $deletePermission = Permission::create(['name' => 'delete books', 'guard_name' => 'admin']);
        // superadmin have all permissions
        $superAdmin->givePermissionTo([$viewPermission, $createPermission, $updatePermission, $deletePermission]);
        // Assign only view permission to admin by default
        $admin->givePermissionTo([$viewPermission]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::where('guard_name', 'admin')->delete();
        Permission::where('guard_name', 'admin')->delete();
    }
};
