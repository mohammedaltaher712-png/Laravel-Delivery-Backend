<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Payment\StorePaymentRequest;
use App\Http\Requests\Admin\Payment\UpdataPaymentRequest;
use App\Models\Payment;
use App\Services\UploadService;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
    public function store(StorePaymentRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();
        $imageResult = null;

        if ($request->hasFile('payments_icon')) {
            $imageResult = $this->uploadService->upload($request->file('payments_icon'), 'paymenticons');

            if ($imageResult['status'] !== 'success') {
                return ResponseHelper::fail('فشل في رفع الصورة.');
            }

            $data['payments_icon'] = $imageResult['filename'];
        } else {
            $data['payments_icon'] = null;
        }

        $payment = Payment::create($data);

        if ($payment) {
            return ResponseHelper::success(
                null,
                $payment,
                null,
                $imageResult['url'] ?? null
            );
        }

        return ResponseHelper::fail('فشل في إنشاء وسيلة الدفع.');
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
        $show = Payment::withTrashed()->get();

        return ResponseHelper::success(null, $show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataPaymentRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');

        }
        $data = $request->validated();
        $id   = $data['payments_id'];

        $Payment = Payment::findOrFail($id);

        if ($request->hasFile('payments_icon')) {
            try {
                $data['payments_icon'] = $this->uploadService->imageUpdate(
                    $request->file('payments_icon'),
                    'paymenticons',
                    $Payment->payments_icon
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }
        unset($data['payments_id']);

        $Payment->update($data);

        return ResponseHelper::success(
            null,
            $Payment,
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
            'id' => 'required|integer|exists:payments,payments_id',
        ]);

        // جلب القائمة حسب الـ id
        $items = Payment::find($request->id);

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
        $items = Payment::onlyTrashed()->find($request->id);

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
}
