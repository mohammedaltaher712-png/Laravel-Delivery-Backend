<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
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
            'items_category' => 'required|integer|exists:category,category_id',
        ]);
        $categoryId = $data['items_category'];

        if (!$categoryId) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (items_category).');

        }
        $banners = Item::where('items_category', $categoryId)->get();

        if ($banners->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $banners);

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
