<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Laravolt\Avatar\Avatar;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Auth check
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $count = $request->count ?? 10;
        $roles = Role::all();
        if ($request->keywords != null) {
            $users = new UserResource(User::where('name', 'like', '%' . $request->keywords . '%')
                ->orWhere('email', 'like', '%' . $request->keywords . '%')
                ->orWhere('phone_number', 'like', '%' . $request->keywords . '%')
                ->paginate($count));
            $loggedUser = auth()->user()->id;
            return response()
                ->json([
                    'users' => $users,
                    'roles' => $roles,
                    'logged_user' => $loggedUser,
                ], 200);
        } else {
            $users = new UserResource(User::latest()->paginate($count));
            $loggedUser = auth()->user()->id;
            return response()
                ->json([
                    'users' => $users,
                    'roles' => $roles,
                    'logged_user' => $loggedUser,
                ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'role' => 'required'
        ]);

        $avatar = new Avatar();
        $imageName = time() . ".png";
        $avatar->create($request->name)->save($imageName);
        File::move(public_path($imageName), storage_path('app/public/image_profiles/' . $imageName));
        $image = 'image_profiles/' . $imageName;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => bcrypt($request->email),
            'image' => $image
        ]);

        $user->assignRole($request->role);

        return response()
            ->json(['msg' => 'ok!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()
            ->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        $user->syncRoles($request->role);

        return response()
            ->json(['msg' => 'ok!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return response()
            ->json(['msg' => 'ok!'], 200);
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->id;
        for ($i = 0; $i < count($data); $i++) {
            $user = User::find($data[$i]);
            if (Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $user->delete();
        }
        return response()
            ->json(['msg' => 'ok!'], 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'password' => bcrypt($user->email)
        ]);
        return response()
            ->json(['msg' => 'ok!']);
    }
}
