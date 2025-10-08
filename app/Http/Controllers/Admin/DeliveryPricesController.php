<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\deliveryPrice\StoreDeliveryPriceRequest;
use App\Models\deliveryPrice;
use Illuminate\Http\Request;

class DeliveryPricesController extends Controller
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
    public function store(StoreDeliveryPriceRequest $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        // استلام البيانات المدخلة
        $data = $request->validated();

        // محاولة إيجاد السجل في قاعدة البيانات
        $deliveryPrice = deliveryPrice::find(1); // استخدم القيمة المناسبة للبحث (هنا افترضت الرقم 1 كمثال)

        // إذا تم العثور على السجل، قم بتحديثه
        if ($deliveryPrice) {
            $deliveryPrice->update($data);

            return response()->json(['message' => 'تم تحديث السعر بنجاح']);
        }

        // إذا لم يتم العثور على السجل، قم بإضافته
        deliveryPrice::create($data);

        return response()->json(['message' => 'تم إضافة السعر بنجاح']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
