<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required|email'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()
                ->json(['msg' => 'Login successfull!'], 200);
        } else {
            return response()
                ->json(['msg' => 'Unable to login, invalid credentials!'], 200);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged Out'], 200);
    }
}
