<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service_providerAdress\StoreAddressRequest;
use App\Http\Requests\Admin\Service_providerAdress\UpdataAddressRequest;
use App\Models\AddressService;
use App\Models\Service;
use Illuminate\Http\Request;

class Service_providerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();
        $Service = Service::findOrFail($data['addressservices_service']);
        $address = $Service->addressService()->create($data);

        return ResponseHelper::success(
            null,
            $address,
            null,
            null,
            'تم الاضافة عنوان جديد بنجاح.'
        );

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data =  $request->validate([
          'addressservices_service' => 'required|integer|exists:services,services_id',
        ]);
        $addressservices_service = $data['addressservices_service'];
        if (!$addressservices_service) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (addressservices_service).');

        }

        // جلب عنوان الخدمة عبر العلاقة
        $address = AddressService::where('addressservices_service', $addressservices_service)->get();

        if ($address->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success($address, null);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataAddressRequest $request)
    {
        $admin = $request->user();

        // التحقق من أن المستخدم أدمن
        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب العنوان باستخدام ID
        $addressService = AddressService::find($data['addressservices_id']);

        if (!$addressService) {
            return ResponseHelper::fail('العنوان غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة
        $fields = [
            'addressservices_name',
            'addressservices_description',
            'addressservices_latitude',
            'addressservices_longitude',
            'addressservices_service', // لو كنت تريد السماح بتغييره أيضًا
        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $addressService->$field = $data[$field];
            }
        }

        // حفظ التغييرات
        $addressService->save();

        return ResponseHelper::success($addressService, 'تم التحديث بنجاح.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
