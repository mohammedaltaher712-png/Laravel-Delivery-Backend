<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        $now = Carbon::now('Asia/Aden')->format('Y-m-d h:i:s A');

        $validCoupons = DB::table('mycoupon')
            ->where('users_id', $user->users_id)
            ->where('coupons_start_date', '<=', $now)
            ->where('coupons_end_date', '>=', $now)
            ->get();

        // صيغة 12 ساعة للعرض فقط

        return ResponseHelper::success($validCoupons);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
