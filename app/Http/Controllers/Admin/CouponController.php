<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdataCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\MyCoupon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
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
    public function store(StoreCouponRequest $request)
    {

        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $validatedData = $request->validated();

        // إنشاء الكوبون
        $coupon = Coupon::create($validatedData);

        return ResponseHelper::success(null, $coupon);

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
        $show = MyCoupon::withoutTrashed()->get();

        return ResponseHelper::success(null, $show);
    }

    public function showstats(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        // جلب الكوبونات غير المفعلة فقط
        $show = DB::table('mycoupon')
            ->where('coupons_is_active', 0)
            ->get();

        return ResponseHelper::success(null, $show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request)
    {
        $admin = $request->user();

        // التحقق من أن المستخدم أدمن
        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب مزود الخدمة باستخدام ID
        $Coupon = Coupon::find($data['coupons_id']);

        if (!$Coupon) {
            return ResponseHelper::fail('مزود الخدمة غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة في الطلب
        if (isset($data['coupons_name'])) {
            $Coupon->coupons_name = $data['coupons_name'];
        }

        if (isset($data['coupons_discount'])) {
            $Coupon->coupons_discount = $data['coupons_discount'];
        }

        if (isset($data['coupons_user'])) {
            $Coupon->coupons_user = $data['coupons_user'];
        }

        if (isset($data['coupons_start_date'])) {
            $Coupon->coupons_start_date = $data['coupons_start_date'];
        }

        if (isset($data['coupons_end_date'])) {
            $Coupon->coupons_end_date = $data['coupons_end_date'];
        }
        if (isset($data['coupons_is_active'])) {
            $Coupon->coupons_is_active = $data['coupons_is_active'];
        }

        // حفظ التغييرات
        $Coupon->save();

        return ResponseHelper::success($Coupon, 'تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updatestatus(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $request->validate([
            'id' => 'required|integer|exists:coupons,coupons_id',
            'status' => 'required|boolean', // نتوقع 0 أو 1
        ]);

        $coupon = Coupon::find($request->id);

        if (!$coupon) {
            return ResponseHelper::fail(null, 'الكوبون غير موجود.');
        }

        // تعيين القيمة القادمة كما هي
        $coupon->coupons_is_active = $request->status;
        $coupon->save();

        $statusText = $coupon->coupons_is_active ? 'تم تفعيل الكوبون بنجاح.' : 'تم إلغاء تفعيل الكوبون.';

        return ResponseHelper::success($coupon, $statusText);
    }
    public function destroy(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $request->validate([
            'id' => 'required|integer|exists:coupons,coupons_id',
        ]);

        // جلب القائمة حسب الـ id
        $items = Coupon::find($request->id);

        if (!$items) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $items->delete();

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
        $items = Coupon::onlyTrashed()->find($request->id);

        if (!$items) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        // استرجاع القائمة
        $items->restore();

        return ResponseHelper::success(
            null,
            $items,
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
        $coupons = MyCoupon::where('coupons_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($coupons->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $coupons, null, null, null, 'تم جلب البيانات بنجاح.');
    }

}
