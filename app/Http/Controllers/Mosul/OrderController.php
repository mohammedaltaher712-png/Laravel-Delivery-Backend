<?php

namespace App\Http\Controllers\Mosul;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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

    public function showcoun(Request $request)
    {

        $results = [

      'orders_id' => Order::where('orders_status', 2)->count(),
            'orders_idfinle' => Order::where('orders_status', 4)->count(),

        ];

        return ResponseHelper::success([$results]); // ← هنا وضعنا الأقواس []
    }
    public function show(Request $request)
    {
        // $admin = $request->user();

        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
        $results = DB::table('ordersview')
    ->whereIn('orders_status', [2, 3])
    ->get();

        return ResponseHelper::success($results);

    }
   public function OrderHistory(Request $request)
{
    $user = $request->user();

    // التحقق من الصلاحية
    if (!$user || !$user->tokenCan('Mosul')) {
        return ResponseHelper::unauthorized('يجب تسجيل الدخول كمُوصّل أولاً.');
    }

    // التحقق من أن الموصّل لديه ID صالح
    if (!isset($user->mosuls_id)) {
        return ResponseHelper::fail('معرف الموصّل غير موجود.');
    }

    // جلب الطلبات التي تم توصيلها بواسطة هذا الموصّل
    $results = DB::table('ordersview')
        ->where('orders_status', 4)
        ->where('orders_mosuls', $user->mosuls_id)
        ->get();

    return ResponseHelper::success($results);
}


    public function updateOrderStatus(Request $request)
    {
        $Mosul = $request->user();

        if (!$Mosul || !$request->user()->tokenCan('Mosul')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول موصل أولاً.');
        }
        $orderId = $request->input('orders_id');
        $order = Order::find($orderId);

        if (!$order) {
            return ResponseHelper::fail(null, 'الطلب غير موجود.');
        }
        $newStatus = $request->input('orders_status');
        $order->orders_status = $newStatus;
        $order->orders_mosuls = $Mosul->mosuls_id;
        $order->save();

        if ($newStatus == 3) {
            $title = "تم قبول الطلب";
            $message = "الطلب مع عامل التوصيل";
        }

        if ($newStatus == 4) {
            $title = "تم تسليم الطلب ";
            $message = " تم تسليم الطلب للعميل";
        }
        $topic = "users{$order->orders_user}";

        $this->firebase->sendToTopic(
            $topic,
            $title,
            $message,
            "none",
            "refreshorderpending"
        );
        $adminTopic = "admin";
        $this->firebase->sendToTopic(
            $adminTopic,
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
    public function destroy(string $id)
    {
        //
    }
}
