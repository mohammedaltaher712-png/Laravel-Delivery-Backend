<?php

namespace App\Http\Controllers\Mosul\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mosul\LoginRequest;
use App\Models\Mosul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $Mosul = Mosul::where('mosuls_email', $data['mosuls_email'])->first();

        if (!$Mosul || !Hash::check($data['mosuls_password'], $Mosul->mosuls_password)) {
            return ResponseHelper::fail();
        }

        // $admin->tokens()->delete();

        // إصدار توكن بصلاحية 'admin'
        $token = $Mosul->createToken('MosulToken', ['Mosul']);

        return ResponseHelper::success($Mosul, null, $token->plainTextToken);

    }
}
