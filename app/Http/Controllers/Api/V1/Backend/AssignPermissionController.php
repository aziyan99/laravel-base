<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()
            ->json($roles, 200);
    }

    public function getPermissions()
    {
        $permissions = \DB::table('permissions')->orderBy('name', 'asc')->get();
        return response()
            ->json($permissions, 200);
    }

    public function getRoleAndPermission(Request $request, $id)
    {
        $count = $request->count ?? 10;
        if ($request->keywords != null) {
            $role = Role::where('id', $id)->first();
            $roleAndPermissions = $role->permissions()
                ->where('name', 'like', '%' . $request->keywords . '%')
                ->paginate($count);
            return response()
                ->json($roleAndPermissions, 200);
        } else {
            $role = Role::where('id', $id)->first();
            $roleAndPermissions = $role->permissions()->paginate($count);
            return response()
                ->json($roleAndPermissions, 200);
        }

        $role = Role::where('id', $id)->first();
        $roleAndPermissions = $role->permissions()->paginate(10);
        $data = [
            'role_and_permissions' => $roleAndPermissions,
        ];
        return response()
            ->json($data, 200);
    }

    public function assignPermission(Request $request)
    {
        $role = Role::where('id', $request->role_id)->first();
        $role->givePermissionTo($request->permission);
        return response()
            ->json(['status' => 'ok!'], 200);
    }

    public function revokePermission(Request $request)
    {
        $role = Role::where('id', $request->role_id)->first();
        $role->revokePermissionTo($request->permission);
        return response()
            ->json(['status' => 'ok!'], 200);
    }
}
