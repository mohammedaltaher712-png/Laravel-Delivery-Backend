<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Favorite\StoreFavoriteReqyest;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
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
    public function store(StoreFavoriteReqyest $request)
    {
        $user = User::find(auth('sanctum')->id()); // فرض نوع User

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        $data = $request->validated();

        // فقط نضيف user_id تلقائيًا عبر العلاقة
        $favorites = $user->favorites()->create($data);

        return ResponseHelper::success(null, null, null, null, null, 'تم إضافة عنصر جديد.');
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

        // جلب الخدمات التي في المفضلة للمستخدم بدون تكرار (حسب services_id)
        $results = DB::table('serviceswithitems')
    ->join('favorites', 'favorites.favorites_services', '=', 'serviceswithitems.services_id')
    ->where('favorites.favorites_user', $user->users_id)
    ->select('serviceswithitems.*', DB::raw('1 as favorite'))  // اضف هذا السطر
    ->groupBy('serviceswithitems.services_id')
    ->get();

        return ResponseHelper::success($results);
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
    public function destroy(Request $request)
    {
        $user = User::find(auth('sanctum')->id());

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }
        $data =  $request->validate([
                   'favorites_services' => 'required|integer|exists:services,services_id',
               ]);
        $serviceId = $data['favorites_services']; // ناخذ قيمة category من query parameters

        if (!$serviceId) {
            return ResponseHelper::fail(null, 'معرف الخدمة مطلوب.');
        }

        // البحث عن السجل المطلوب حذفه
        $favorite = Favorite::where('favorites_user', $user->users_id)
            ->where('favorites_services', $serviceId)
            ->first();

        if (!$favorite) {
            return ResponseHelper::fail(null, 'العنصر غير موجود في المفضلة.');
        }

        $favorite->delete();

        return ResponseHelper::success(null, null, null, null, null, 'تمت إزالة العنصر من المفضلة.');
    }

}
