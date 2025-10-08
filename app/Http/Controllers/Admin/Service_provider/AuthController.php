<?php

namespace App\Http\Controllers\Admin\Service_provider;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service_provider\Auth\RegisterRequest;
use App\Models\Service_Provider;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function register(RegisterRequest $request)
    {
        $data                              = $request->validated();
        $data['service_provider_password'] = bcrypt($data['service_provider_password']);

        $user = Service_Provider::create($data);

        $token = $user->createToken('UserToken')->plainTextToken;

        return ResponseHelper::success($user, null, $token);

    }

}
