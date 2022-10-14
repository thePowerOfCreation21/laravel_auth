<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login (Request $request)
    {
        $loginData = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('name', $loginData['name'])->first();

        if (! empty($admin) && Hash::check($loginData['password'], $admin->password))
        {
            $token = $admin->createToken('auth_token');
            return response()->json([
                'token' => $token->plainTextToken
            ]);
        }

        return response()->json([
            'message' => 'login data is wrong'
        ], 401);
    }

    public function getAdminByRequest (Request $request)
    {
        return $request->user();
    }
}
