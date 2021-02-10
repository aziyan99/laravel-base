<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getGeneralInformation()
    {
        $user = User::findOrFail(auth()->user()->id);
        return response()
            ->json($user, 200);
    }

    public function updateGeneralInformation(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . auth()->user()->id,
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);
        return response()
            ->json(['msg' => 'ok!'], 200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $user->update([
            'password' => bcrypt($request->password)
        ]);
        return response()
            ->json(['msg' => 'ok!'], 200);
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);
        $image = $request->file('image');
        $input['imageName'] = time() . '.' . $image->extension();
        $image = Image::make($image->getRealPath());
        $image->resize(100, 100);
        $image->save(storage_path() . DIRECTORY_SEPARATOR . 'app/public/image_profiles/' . $input['imageName'], 80);

        $user = User::findOrFail(auth()->user()->id);

        if (Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->update([
            'image' => 'image_profiles' . "/" . $input['imageName']
        ]);

        return response()
            ->json(['msg' => 'ok!'], 200);
    }
}
