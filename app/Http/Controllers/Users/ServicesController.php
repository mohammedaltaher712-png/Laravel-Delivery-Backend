<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ServicesWithItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
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
        $data =  $request->validate([
                  'items_id' => 'required|integer|exists:items,items_id',
              ]);
        $itemsId = $data['items_id'];

        if (!$itemsId) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (items_id).');
        }

        $services = ServicesWithItems::query()
            ->where('items_id', $itemsId)
            ->select([
                'serviceswithitems.*',
            ])
            ->selectSub(function ($query) use ($user) {
                $query->from('favorites')
                      ->selectRaw('1')
                      ->whereColumn('favorites.favorites_services', 'serviceswithitems.services_id')
                      ->where('favorites.favorites_user', $user->users_id)
                      ->limit(1);
            }, 'favorite')
            ->limit(25)
            ->get()
            ->each(function ($service) {
                // إذا كان null نرجعه 0
                $service->favorite = $service->favorite ?? 0;
            });

        if ($services->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد خدمات لهذا التصنيف.');
        }

        return ResponseHelper::success(null, $services, null, null, null, 'تم جلب البيانات بنجاح.');
    }

    public function search(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        $data = $request->validate([
            'query' => 'required|string|min:1'
        ]);
        $searchTerm = $data['query'];

        $services = ServicesWithItems::query()
            ->where('services_name', 'LIKE', "%{$searchTerm}%")
            ->select([
                'serviceswithitems.*',
            ])
            ->selectSub(function ($query) use ($user) {
                $query->from('favorites')
                    ->selectRaw('1')
                    ->whereColumn('favorites.favorites_services', 'serviceswithitems.services_id')
                    ->where('favorites.favorites_user', $user->users_id)
                    ->limit(1);
            }, 'favorite')
            ->limit(100) // جلب عدد أكبر لتقليل احتمال فقدان بعض النتائج بعد التصفية
            ->get()
            ->unique('services_id') // ✅ هذا يزيل التكرار بناءً على services_id
            ->values() // إعادة ترتيب الـ index
            ->each(function ($service) {
                $service->favorite = $service->favorite ?? 0;
            });

        if ($services->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $services, null, null, null, 'تم جلب البيانات بنجاح.');
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
