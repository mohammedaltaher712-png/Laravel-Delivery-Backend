<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Order\StoreOrdersRequest;
use App\Models\Card;
use App\Models\Order;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ordersController extends Controller
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
    public function store(StoreOrdersRequest $request)
    {
        $user = User::find(auth('sanctum')->id());

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        $data = $request->validated();
        $data['orders_user'] = $user->users_id;
        $discount = $data['discountcoupon'] ?? 0;

        if ($discount > 0) {
            $originalPrice = $data['orders_price'];
            $data['orders_price'] = $originalPrice - ($originalPrice * $discount / 100);
        }

        unset($data['discountcoupon']); // ✅ إزالة الحقل قبل الإنشاء، لأنه غير موجود في الجدول
        // إنشاء الطلب
        $order = Order::create($data);

        // تحديث cart: تعيين carts_orders = orders_id للطلبات المؤقتة (carts_orders = 0)
        Card::where('carts_user', $user->users_id)
            ->where('carts_orders', 0)
            ->update(['carts_orders' => $order->orders_id]);

        $this->firebase->sendToTopic(
            "admin",
            "تم بنجاح",
            "تم ارسال الطلب ",
            "none",
            "refreshorderpending"
        );

        return ResponseHelper::success(null, 'تم إنشاء الطلب بنجاح وتم إرسال إشعار.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        // ✅ جلب فقط cart الذي لم يتم ربطه بطلب (carts_orders = 0)
        $results = DB::table('ordersview')
            ->where('orders_user', $user->users_id)
            ->get();

        return ResponseHelper::success($results);

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
