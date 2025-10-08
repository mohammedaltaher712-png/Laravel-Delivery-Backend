<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Requests\Users\Auth\RegisterStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterStoreRequest $request)
    {
        $data = $request->validated();
        $data['users_password'] = bcrypt($data['users_password']);

        $user = User::create($data);

        $token = $user->createToken('UserToken')->plainTextToken;

        return ResponseHelper::success($$user, null, $token->plainTextToken);

    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('users_email', $request->users_email)->first();

        if (!$user || !Hash::check($request->users_password, $user->users_password)) {
            return ResponseHelper::fail(null, 'بيانات الدخول غير صحيحة');

        }
        // $user->tokens()->delete();

        $token = $user->createToken('UserToken', [])->plainTextToken;

        return ResponseHelper::success($user, null, $token);

    }

}
