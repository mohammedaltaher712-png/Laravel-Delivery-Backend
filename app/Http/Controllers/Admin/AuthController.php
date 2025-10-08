<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data                    = $request->validated();
        $data['admins_password'] = bcrypt($data['admins_password']);

        $admin = Admin::create($data);

        $token = $admin->createToken('UserToken')->plainTextToken;

        return ResponseHelper::success($admin, null, $token->plainTextToken);


    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $admin = Admin::where('admins_email', $data['admins_email'])->first();

        if (!$admin || !Hash::check($data['admins_password'], $admin->admins_password)) {
            return ResponseHelper::fail();
        }

        // $admin->tokens()->delete();

        // إصدار توكن بصلاحية 'admin'
        $token = $admin->createToken('AdminToken', ['admin']);

        return ResponseHelper::success($admin, null, $token->plainTextToken);


    }


}
