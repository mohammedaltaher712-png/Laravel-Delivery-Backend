<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class CountController extends Controller
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
        //   $admin = $request->user();

        // if (!$admin || !$request->user()->tokenCan('admin')) {
        //     return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        // }
        $results = [
            'users_id' => User::count(),
            'services_id' => Service::count(),
'orders_id' => Order::where('orders_status', 1)->count(),
        ];

        return ResponseHelper::success([$results]); // ← هنا وضعنا الأقواس []
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
