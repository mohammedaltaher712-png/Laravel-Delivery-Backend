<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Address\StoreAddressRequest;
use App\Http\Requests\Users\Address\UpdataAddressRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AddressController extends Controller
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
    public function store(StoreAddressRequest $request)
    {
        $user = User::find(auth('sanctum')->id()); // فرض نوع User

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');

        }

        $data = $request->validated();

        $address = $user->addresses()->create($data);

        return ResponseHelper::success($address);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = User::find(auth('sanctum')->id()); // فرض نوع User

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');

        }

        // جلب عناوين المستخدم
        $addresses = $user->addresses()->get();

        return ResponseHelper::success($addresses);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataAddressRequest $request)
    {
        $user = User::find(auth('sanctum')->id());
        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');

        }

        $data = $request->validated();

        $address = $user->addresses()
            ->where('addressusers_id', $data['addressusers_id'])
            ->first();

        if (!$address) {
            return ResponseHelper::fail(null, 'العنوان غير موجود أو لا يتبع هذا المستخدم.', );

        }

        // حدث الحقول الموجودة فقط
        $address->update($data);

        return ResponseHelper::success($address, null, null, null, null, 'تم تعديل العنوان بنجاح.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::find(auth('sanctum')->id());

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');

        }

        // تحقق من وجود رقم العنوان وإرساله
        $request->validate([
            'addressusers_id' => 'required|integer|exists:addressusers,addressusers_id',
        ]);

        $addressId = $request->input('addressusers_id');

        // ابحث عن العنوان عبر العلاقة مع المستخدم
        $address = $user->addresses()->where('addressusers_id', $addressId)->first();

        if (!$address) {
            return ResponseHelper::fail(null, 'العنوان غير موجود أو لا يتبع هذا المستخدم.');

        }

        $address->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف العنوان بنجاح.');

    }

}
