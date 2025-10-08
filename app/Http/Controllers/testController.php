<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class testController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
public function updateOrderStatus(Request $request)
{
    // جلب الطلب حسب الـ orders_id المرسل من الـ Request
    $orderId = $request->input('orders_id');
    $order = Order::find($orderId);

    if (!$order) {
        return ResponseHelper::fail(null, 'الطلب غير موجود.');
    }

    // تحديث حالة الطلب
    $newStatus = $request->input('orders_status');
    $order->orders_status = $newStatus;
    $order->save();

    // تحديد نص الإشعار بناءً على الحالة
    switch ($newStatus) {
        case 0:
            $title = "تم إلغاء الطلب";
            $message = "نأسف، وبشدة عملنا تم إلغاء طلبك.";
            break;
        case 2:
            $title = "تحضير الطلب";
            $message = "طلبك قيد التحضير الآن.";
            break;
        default:
            $title = "تحديث حالة الطلب";
            $message = "تم تغيير حالة طلبك إلى: $newStatus";
            break;
    }

    // إرسال الإشعار للمستخدم صاحب الطلب
    $topic = "users{$order->orders_user}";
    $this->firebase->sendToTopic(
        $topic,
        $title,
        $message,
        "none",
        "refreshorderpending"
    );

    return ResponseHelper::success($order, 'تم تحديث حالة الطلب بنجاح وتم إرسال إشعار.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
