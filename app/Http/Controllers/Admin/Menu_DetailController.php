<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu_Detail\StoreMenu_DetailRequest;
use App\Http\Requests\Admin\Menu_Detail\UpdataMenu_DetailRequest;
use App\Models\Menu;
use App\Models\Menu_Detail;
use App\Models\Service;
use App\Services\UploadService;
use Illuminate\Http\Request;

class Menu_DetailController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenu_DetailRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // التحقق من وجود السجلات المرتبطة
        $service = Service::findOrFail($data['menu_details_services']);
        $menu = Menu::where('menus_id', $data['menu_details_menus'])

                            ->first();

        if (!$menu) {
            return ResponseHelper::fail(null, 'القائمة المحددة لا تتبع خدمتك.');

        }
        $menu = Menu::findOrFail($data['menu_details_menus']);

        // رفع الصورة إن وُجدت
        if ($request->hasFile('menu_details_image')) {
            $imageResult = $this->uploadService->upload($request->file('menu_details_image'), 'menudetailsimage');

            if ($imageResult['status'] !== 'success') {
                return ResponseHelper::fail('فشل في رفع الصور');
            }

            $data['menu_details_image'] = $imageResult['filename'];
        }

        $menuDetail = $service->menuDetails()->create($data);

        return ResponseHelper::success(
            null,
            $menuDetail,
            null,
            null,
            'تمت إضافة عنصر جديد في القائمة بنجاح.'
        );

    }

    public function showmenu(Request $request)
    {

        $menus = Menu::withTrashed()->get();

        return ResponseHelper::success($menus, null);

    }
    public function show(Request $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data =  $request->validate([
          'menu_details_menus' => 'required|integer|exists:menus,menus_id',
        ]);
        $menu_details_menus = $data['menu_details_menus'];
        if (!$menu_details_menus) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (menu_details_menus).');

        }
        $Menu_Detail = Menu_Detail::withTrashed()
    ->where('menu_details_menus', $menu_details_menus)
    ->get();
      

        return ResponseHelper::success($Menu_Detail, null);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataMenu_DetailRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        $menuDetail = Menu_Detail::findOrFail($data['menu_details_id']);

        if (!$menuDetail) {
            return ResponseHelper::fail('العنوان غير موجود.');
        }

        if ($request->hasFile('menu_details_image')) {
            try {
                $data['menu_details_image'] = $this->uploadService->imageUpdate(
                    $request->file('menu_details_image'),
                    'menudetailsimage',
                    $menuDetail->menu_details_image
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }

        // تحديث الحقول إذا كانت موجودة
        $fields = [
            'menu_details_name',
            'menu_details_description',
                      'menu_details_price',
            'menu_details_menus',
            'menu_details_services',
             'menu_details_image',

        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $menuDetail->$field = $data[$field];
            }
        }

        // حفظ التغييرات
        $menuDetail->save();

        return ResponseHelper::success($menuDetail, 'تم التحديث بنجاح.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer|exists:menu_details,menu_details_id',
        ]);

        // جلب القائمة حسب الـ id
        $Menu_Detail = Menu_Detail::find($request->id);

        if (!$Menu_Detail) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $Menu_Detail->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف القائمة بنجاح (حذف ناعم).');

    }
    public function restore(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer',
        ]);

        // جلب القائمة المحذوفة فقط (soft deleted)
        $Menu_Detail = Menu_Detail::onlyTrashed()->find($request->id);

        if (!$Menu_Detail) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        $Menu_Detail->restore();

        return ResponseHelper::success(
            null,
            $Menu_Detail,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

    }
}
