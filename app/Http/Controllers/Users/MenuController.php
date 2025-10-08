<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
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
           'menus_services' => 'required|integer|exists:services,services_id',
        ]);
        $serviceId = $data['menus_services'];

        if (!$serviceId) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (menus_services ).');

        }
        $Menu = Menu::where('menus_services', $serviceId)->get();

        if ($Menu->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $Menu);

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
