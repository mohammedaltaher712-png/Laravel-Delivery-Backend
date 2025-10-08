<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Services\StoreServiceRequest;
use App\Http\Requests\Admin\Services\UpdataServicesRequest;
use App\Models\Service;
use App\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function index()
    {
        //
    }

    public function store(StoreServiceRequest $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $data = $request->validated();

        $imageResult = $this->uploadService->upload($request->file('services_image'), 'servicesimage');
        $iconResult  = $this->uploadService->upload($request->file('services_icon'), 'servicesicon');
        if ($imageResult['status'] !== 'success' || $iconResult['status'] !== 'success') {
            return ResponseHelper::fail('فشل في رفع الصور');
        }
        $data['services_image'] = $imageResult['filename'];
        $data['services_icon']  = $iconResult['filename'];

        $service = Service::create($data);
        if ($service) {
            $service->items()->attach($data['items']);

            return ResponseHelper::success(null, $service->load('items'), null);

        }

        return ResponseHelper::fail();
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
          'services_belongs' => 'required|integer|exists:service_provider,service_provider_id',
        ]);
        $services_belongs = $data['services_belongs'];
        if (!$services_belongs) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (services_belongs).');

        }
        $Service = Service::withTrashed()
            ->where('services_belongs', $services_belongs)
            ->get();

        if ($Service->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $Service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataServicesRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data    = $request->validated();
        $service = Service::findOrFail($data['services_id']);
        foreach (['services_image' => 'servicesimage', 'services_icon' => 'servicesicon'] as $field => $folder) {
            if ($request->hasFile($field)) {
                try {
                    $oldImage     = $service->{$field} ?? null;
                    $data[$field] = $this->uploadService->imageUpdate(
                        $request->file($field),
                        $folder,
                        $oldImage
                    );
                } catch (\Exception $e) {
                    return ResponseHelper::fail($e->getMessage());

                }
            }
        }

        unset($data['services_id']);
        $service->update($data);

        if (isset($data['items'])) {
            $service->items()->sync($data['items']);
        }

        return ResponseHelper::success(
            null,
            $service->load('items'),
            null,
            null,
            'تم تعديل التصنيف بنجاح.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $request->validate([
            'id' => 'required|integer|exists:services,services_id',
        ]);

        // جلب القائمة حسب الـ id
        $menu = Service::find($request->id);

        if (!$menu) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $menu->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف القائمة بنجاح (حذف ناعم).');

    }
    public function restore(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }        $request->validate([
            'id' => 'required|integer',
        ]);

        // جلب القائمة المحذوفة فقط (soft deleted)
        $Menu_Detail = Service::onlyTrashed()->find($request->id);

        if (!$Menu_Detail) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        // استرجاع القائمة
        $Menu_Detail->restore();

        return ResponseHelper::success(
            null,
            $Menu_Detail,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

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
        $Service = Service::where('services_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($Service->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $Service, null, null, null, 'تم جلب البيانات بنجاح.');
    }
}
