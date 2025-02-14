<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function assignPermissions(Request $request, $adminId)
    {
        $admin = Admin::findOrFail($adminId);
        //can assgin more one permission
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        // Sync permissionsremove old and assign new ones
        $admin->syncPermissions($request->permissions);
        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
