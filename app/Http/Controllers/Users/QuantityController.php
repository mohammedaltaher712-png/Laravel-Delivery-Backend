<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = auth('sanctum')->user();

        $data = $request->validate([
            'quantitys_menu_details' => 'required|integer|exists:quantitys,quantitys_id',
        ]);

        $quantityMenuId = $data['quantitys_menu_details'];

        $quantities = Quantity::where('quantitys_menu_details', $quantityMenuId)->get();

        if ($quantities->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد كميات لهذا التصنيف.');
        }

        $results = [];

        foreach ($quantities as $quantity) {
            // نحول العنصر إلى مصفوفة بدل الكائن
            $item = $quantity->toArray();

            // قيم افتراضية للكمية والسعر في السلة
            $item['added_quantity'] = 0;
            $item['added_total_price'] = 0;

            if ($user) {
                $cartData = DB::table('cardview')
                    ->where('users_id', $user->users_id)
                    ->where('carts_quantitys', $quantity->quantitys_id)
                    ->where('carts_orders', 0)

                    ->selectRaw('SUM(quantity_count) as total_quantity, SUM(total_price) as total_price')
                    ->first();

                $item['added_quantity'] = $cartData->total_quantity ?? 0;
                $item['added_total_price'] = $cartData->total_price ?? 0;
            }

            $results[] = $item;
        }

        // حساب إجمالي السعر لجميع العناصر في سلة المستخدم
        $totalPrice = 0;
        if ($user) {
            $totalPrice = DB::table('cardview')
                ->where('users_id', $user->users_id)
                ->where('carts_orders', 0)

                ->sum('total_price');
        }

        // ترجع فقط مصفوفة العناصر (بدون غلاف 'data' أو أي شيء إضافي)
        return ResponseHelper::success(
            $results,
            null,
            $totalPrice
        );
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
