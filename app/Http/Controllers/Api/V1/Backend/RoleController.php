<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
            $roles = new RoleResource(Role::where('name', 'like', '%' . $request->keywords . '%')
                ->orWhere('guard_name', 'like', '%' . $request->keywords . '%')
                ->paginate($count));
            return response()
                ->json($roles, 200);
        } else {
            $roles = new RoleResource(Role::latest()->paginate($count));
            return response()
                ->json($roles, 200);
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
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required'
        ]);
        Role::create($request->all());
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
            'name' => 'required|unique:roles,name,' . $id,
            'guard_name' => 'required'
        ]);
        $role = Role::findOrFail($id);
        $role->update($request->all());
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
        Role::destroy($id);
        return response()
            ->json(['msg' => 'ok'], 200);
    }

    /**
     * Bulk Destroy
     *
     * @param Request $request
     * @return void
     */
    public function bulkDestroy(Request $request)
    {
        $data = $request->id;
        for ($i = 0; $i < count($data); $i++) {
            $role = Role::destroy($data[$i]);
        }
        return response()
            ->json(['msg' => 'Role deleted!']);
    }
}
