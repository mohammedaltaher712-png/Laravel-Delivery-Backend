<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mosul\RegsterauthRequest;
use App\Http\Requests\Admin\Mosul\UpdataMosulRequest;
use App\Models\Mosul;
use Illuminate\Http\Request;

class MosulAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(RegsterauthRequest $request)
    {

        // $admin = $request->user();
        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
        $data                              = $request->validated();
        $data['mosuls_password'] = bcrypt($data['mosuls_password']);

        $user = Mosul::create($data);

        $token = $user->createToken('MosulToken')->plainTextToken;

        return ResponseHelper::success($user, null, $token);

    }

    public function show(Request $request)
    {
        // $admin = $request->user();
        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
        $show = Mosul::withTrashed()->get();

        return ResponseHelper::success(null, $show);
    }

    public function update(UpdataMosulRequest $request)
    {

        // $admin = $request->user();

        // // التحقق من أن المستخدم أدمن
        // if (!$admin || !$admin->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }

        $data = $request->validated();

        // جلب مزود الخدمة باستخدام ID
        $Mosul = Mosul::find($data['mosuls_id']);

        if (!$Mosul) {
            return ResponseHelper::fail('مزود الخدمة غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة في الطلب
        if (isset($data['mosuls_name'])) {
            $Mosul->mosuls_name = $data['mosuls_name'];
        }

        if (isset($data['mosuls_email'])) {
            $Mosul->mosuls_email = $data['mosuls_email'];
        }

        if (isset($data['mosuls_phone'])) {
            $Mosul->mosuls_phone = $data['mosuls_phone'];
        }

        if (isset($data['mosuls_password'])) {
            $Mosul->mosuls_password = bcrypt($data['mosuls_password']);
        }

        // حفظ التغييرات
        $Mosul->save();

        return ResponseHelper::success($Mosul, 'تم التحديث بنجاح');
    }

    public function search(Request $request)
    {
        // $admin = $request->user();

        // if (!$admin || !$admin->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }

        $data = $request->validate([
            'query' => 'required|string|min:1'
        ]);

        $searchTerm = $data['query'];

        // تنفيذ الاستعلام والبحث
        $User = Mosul::where('mosuls_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($User->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $User, null, null, null, 'تم جلب البيانات بنجاح.');
    }

    public function destroy(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer|exists:mosuls,mosuls_id',
        ]);

        // جلب القائمة حسب الـ id
        $Mosul = Mosul::find($request->id);

        if (!$Mosul) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $Mosul->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف القائمة بنجاح (حذف ناعم).');

    }
    public function restore(Request $request)
    {
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer',
        ]);

        // جلب القائمة المحذوفة فقط (soft deleted)
        $Mosul = Mosul::onlyTrashed()->find($request->id);

        if (!$Mosul) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        $Mosul->restore();

        return ResponseHelper::success(
            null,
            $Mosul,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

    }
}
