<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Menu_Detail;
use Illuminate\Http\Request;

class Menu_DetailController extends Controller
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
        $data =  $request->validate([
            'menu_details_menus' => 'required|integer|exists:menus,menus_id',
        ]);
        $Menu_DetailID = $data['menu_details_menus'];

        if (!$Menu_DetailID) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (menu_details_menus).');

        }
        $Menu_Detail = Menu_Detail::where('menu_details_menus', $Menu_DetailID)->get();

        if ($Menu_Detail->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $Menu_Detail);

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
