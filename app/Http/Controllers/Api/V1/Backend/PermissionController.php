<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    /**
     * Sanctum check
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $count = $request->count ?? 10;
        if ($request->keywords != null) {
            $permissions = new PermissionResource(Permission::where('name', 'like', '%' . $request->keywords . '%')
                ->orWhere('guard_name', 'like', '%' . $request->keywords . '%')
                ->paginate($count));
            return response()
                ->json($permissions, 200);
        } else {
            $permissions = new PermissionResource(Permission::latest()->paginate($count));
            return response()
                ->json($permissions, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required'
        ]);
        Permission::create($request->all());
        return response()
            ->json(['msg' => 'ok'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'guard_name' => 'required'
        ]);
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        return response()
            ->json(['msg' => 'ok'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        return response()
            ->json(['msg' => 'ok'], 200);
    }

    /**
     * Bulk destroy
     *
     * @param Request $request
     * @return void
     */
    public function bulkDestroy(Request $request)
    {
        $data = $request->id;
        for ($i = 0; $i < count($data); $i++) {
            Permission::destroy($data[$i]);
        }
        return response()
            ->json(['msg' => 'ok!'], 200);
    }
}
