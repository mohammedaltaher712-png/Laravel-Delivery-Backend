<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $admin = $request->user();

        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
        $results = DB::table('ordersview')
            ->where('orders_status', 1)
            ->get();

        return ResponseHelper::success($results);

    }
    public function OrderHistory(Request $request)
    {
        // $admin = $request->user();
        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }

        $orders_status = $request->input('orders_status');

        // ✅ جلب فقط cart الذي لم يتم ربطه بطلب (carts_orders = 0)
        $results = DB::table('ordersview')
            ->where('orders_status', $orders_status)
            ->get();

        return ResponseHelper::success($results);

    }
    /**
     * Update the specified resource in storage.
     */
    public function updateOrderStatus(Request $request)
    {
        // $admin = $request->user();
        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
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
     * Remove the specified resource from storage.
     */

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

    $results = DB::table('ordersview')
        ->where('orders_status', 1)
        ->where('orders_id', 'LIKE', "%{$searchTerm}%")
        ->get();

    if ($results->isEmpty()) {
        return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
    }

    return ResponseHelper::success(null, $results, null, null, null, 'تم جلب البيانات بنجاح.');
}

    public function destroy(string $id)
    {
        //
    }
}
