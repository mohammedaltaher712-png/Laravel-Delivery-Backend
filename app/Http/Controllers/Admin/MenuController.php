<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreMenusRequest;
use App\Http\Requests\Admin\Menu\UpdataMenusRequest;
use App\Models\Menu;
use App\Models\Service;
use Illuminate\Http\Request;

class MenuController extends Controller
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
    public function store(StoreMenusRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();
        $Service = Service::findOrFail($data['menus_services']);
        $address = $Service->menus()->create($data);

        return ResponseHelper::success(
            null,
            $address,
            null,
            null,
            'تم الاضافة عنوان جديد بنجاح.'
        );

    }

    public function showService(Request $request)
    {

        // $admin = $request->user();

        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }

        $Service = Service::all();

        return ResponseHelper::success($Service, null);

    }
    public function show(Request $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data =  $request->validate([
          'menus_services' => 'required|integer|exists:services,services_id',
        ]);
        $menus_services = $data['menus_services'];
        if (!$menus_services) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (menus_services).');

        }
$menus = Menu::withTrashed()
    ->where('menus_services', $menus_services)
    ->get();


        return ResponseHelper::success($menus, null);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataMenusRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب العنوان باستخدام ID
        $Menu = Menu::find($data['menus_id']);

        if (!$Menu) {
            return ResponseHelper::fail('العنوان غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة
        $fields = [
            'menus_name',
            'menus_services',

        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $Menu->$field = $data[$field];
            }
        }

        // حفظ التغييرات
        $Menu->save();

        return ResponseHelper::success($Menu, 'تم التحديث بنجاح.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer|exists:menus,menus_id',
        ]);

        // جلب القائمة حسب الـ id
        $menu = Menu::find($request->id);

        if (!$menu) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $menu->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف القائمة بنجاح (حذف ناعم).');

    }
    public function restore(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer',
        ]);

        // جلب القائمة المحذوفة فقط (soft deleted)
        $menu = Menu::onlyTrashed()->find($request->id);

        if (!$menu) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        $menu->restore();

        return ResponseHelper::success(
            null,
            $menu,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

    }
}
