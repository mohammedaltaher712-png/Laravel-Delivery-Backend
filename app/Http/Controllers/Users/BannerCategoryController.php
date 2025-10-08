<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\BannerCategory;
use Illuminate\Http\Request;

class BannerCategoryController extends Controller
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
            'category_id' => 'required|integer|exists:category,category_id',
        ]);

        $categoryId = $data['category_id']; // ناخذ قيمة category من query parameters

        if (!$categoryId) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (category).');

        }

        $banners = BannerCategory::where('banner_categorys_category', $categoryId)->get();

        if ($banners->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success($banners, null);

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
