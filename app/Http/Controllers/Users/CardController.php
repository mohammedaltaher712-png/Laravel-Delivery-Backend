<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Card\StoreCardRequest;
use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::with(['service', 'menuDetail', 'quantity', 'user'])->get();

        return ResponseHelper::success($cards, null);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $user = User::find(auth('sanctum')->id());

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
        }

        $data = $request->validated();

        // فقط نضيف user_id تلقائيًا عبر العلاقة
        $card = $user->cards()->create($data);

        return ResponseHelper::success(null, $card, null, null, null, 'تم إضافة عنصر جديد.');
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

        // استعلام العدّ
        $results = DB::table('carts')
            ->select('carts_quantitys', DB::raw('COUNT(carts_id) as count'))
            ->where('carts_user', $user->users_id)
            ->where('carts_orders', 0)
            ->groupBy('carts_quantitys')
            ->get();

        return ResponseHelper::success($results, null);
    }

  public function showCartView(Request $request)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return ResponseHelper::fail(null, 'يجب تسجيل الدخول أولاً.');
    }

    // ✅ جلب فقط cart الذي لم يتم ربطه بطلب (carts_orders = 0)
    $results = DB::table('cardview')
        ->where('users_id', $user->users_id)
        ->where('carts_orders', 0)
        ->get();

    // ✅ مجموع السعر لنفس الفلاتر
    $totalPrice = DB::table('cardview')
        ->where('users_id', $user->users_id)
        ->where('carts_orders', 0)
        ->sum('total_price');

    // ✅ مجموع الكميات
    $totalQuantity = DB::table('cardview')
        ->where('users_id', $user->users_id)
        ->where('carts_orders', 0)
        ->sum('quantity_count'); // تأكد من اسم العمود

    return ResponseHelper::success($results, null, $totalPrice, null, null, null, $totalQuantity);
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

    public function decreaseQuantityByQuantityId(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');

        }

        // تحقق من وجود cards_quantitys
        $request->validate([
            'carts_quantitys' => 'required|integer|exists:carts,carts_quantitys',
        ]);

        // البحث عن العنصر المطابق بناءً على cards_quantitys والمستخدم
        $card = \App\Models\Card::where('carts_quantitys', $request->carts_quantitys)
            ->where('carts_user', $user->users_id)
            ->where('carts_orders', 0)
            ->first();

        if (!$card) {
            return ResponseHelper::fail(null, 'العنصر غير موجود في السلة أو لا ينتمي لهذا المستخدم.');

        }

        // تقليل الكمية أو حذف العنصر
        if ($card->carts_amount > 1) {
            $card->carts_amount -= 1;
            $card->save();

            return ResponseHelper::success(null, $card, null, null, null, 'تم تقليل الكمية.');

        } else {
            $card->delete();

            return ResponseHelper::success(null, null, null, null, 'تم حذف العنصر من السلة.');

        }
    }

    public function destroy(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return ResponseHelper::fail(null, 'يجب تسجيل الدخول مستخدم أولاً.');
        }

        // تحقق من وجود carts_quantitys
        $request->validate([
            'carts_quantitys' => 'required|integer|exists:carts,carts_quantitys',
        ]);

        // البحث عن العناصر المطابقة بناءً على carts_quantitys والمستخدم
        $cards = \App\Models\Card::where('carts_quantitys', $request->carts_quantitys)
            ->where('carts_user', $user->users_id)
            ->where('carts_orders', 0)
            ->get();

        if ($cards->isEmpty()) {
            return ResponseHelper::fail(null, 'العنصر غير موجود في السلة أو لا ينتمي لهذا المستخدم.');
        }

        // حذف جميع العناصر التي تطابق هذا الـ quantity
        $cards->each(function ($card) {
            $card->delete(); // حذف كل عنصر من السلة
        });

        return ResponseHelper::success(null, null, null, null, 'تم حذف جميع العناصر من السلة.');
    }
}
