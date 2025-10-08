<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Quantity\StoreQuantityRequest;
use App\Http\Requests\Admin\Quantity\UpdataQuantityRequest;
use App\Models\Menu_Detail;
use App\Models\Quantity;
use Illuminate\Http\Request;

class QuantityController extends Controller
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
    public function store(StoreQuantityRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');

        }

        $data = $request->validated();
        $Menu_Detail = Menu_Detail::findOrFail($data['quantitys_menu_details']);
        $save = $Menu_Detail->quantitys()->create($data);

        return ResponseHelper::success(
            null,
            $save,
            null,
            null,
            'تم الاضافة الكمية جديد بنجاح.'
        );

    }

    public function showMenu_Detail(Request $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $Menu_Detail = Menu_Detail::all();

        return ResponseHelper::success($Menu_Detail, null);

    }
    public function show(Request $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data =  $request->validate([
          'quantitys_menu_details' => 'required|integer|exists:menu_details,menu_details_id',
        ]);
        $quantitys_menu_details = $data['quantitys_menu_details'];
        if (!$quantitys_menu_details) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (quantitys_menu_details).');

        }
        $menus = Quantity::where('quantitys_menu_details', $quantitys_menu_details)

                   ->get();

        return ResponseHelper::success($menus, null);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataQuantityRequest $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب العنوان باستخدام ID
        $Menu = Quantity::find($data['quantitys_id']);

        if (!$Menu) {
            return ResponseHelper::fail('العنوان غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة
        $fields = [
            'quantitys_name',
            'quantitys_price',
                      'quantitys_menu_details',

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
    public function destroy(string $id)
    {
        //
    }
}
