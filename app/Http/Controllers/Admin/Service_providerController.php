<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service_provider\StoreService_providerRequest;
use App\Http\Requests\Admin\Service_provider\UpdataService_providerRequest;
use App\Http\Requests\Service_provider\Auth\RegisterRequest;
use App\Models\Service_Provider;
use Illuminate\Http\Request;

class Service_providerController extends Controller
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
    public function store(StoreService_providerRequest $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $data                              = $request->validated();
        $data['service_provider_password'] = bcrypt($data['service_provider_password']);

        $user = Service_Provider::create($data);

        return ResponseHelper::success($user);
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
        $show = Service_Provider::all();

        return ResponseHelper::success(null, $show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataService_providerRequest $request)
    {
        $admin = $request->user();

        // التحقق من أن المستخدم أدمن
        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب مزود الخدمة باستخدام ID
        $serviceProvider = Service_Provider::find($data['service_provider_id']);

        if (!$serviceProvider) {
            return ResponseHelper::fail('مزود الخدمة غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة في الطلب
        if (isset($data['service_provider_name'])) {
            $serviceProvider->service_provider_name = $data['service_provider_name'];
        }

        if (isset($data['service_provider_email'])) {
            $serviceProvider->service_provider_email = $data['service_provider_email'];
        }

        if (isset($data['service_provider_phone'])) {
            $serviceProvider->service_provider_phone = $data['service_provider_phone'];
        }

        if (isset($data['service_provider_password'])) {
            $serviceProvider->service_provider_password = bcrypt($data['service_provider_password']);
        }

        // حفظ التغييرات
        $serviceProvider->save();

        return ResponseHelper::success($serviceProvider, 'تم التحديث بنجاح');
    }
 public function search(Request $request)
    {
       $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        } 

        $data = $request->validate([
            'query' => 'required|string|min:1'
        ]);

        $searchTerm = $data['query'];

        // تنفيذ الاستعلام والبحث
        $Service_Provider = Service_Provider::where('service_provider_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($Service_Provider->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $Service_Provider, null, null, null, 'تم جلب البيانات بنجاح.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
