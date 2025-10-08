<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BnnerCategory\StoreBannerCategoryRequest;
use App\Http\Requests\Admin\BnnerCategory\UpdataBannerCategoryRequest;
use App\Models\BannerCategory;
use App\Models\Category;
use App\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;  // تأكد من استيراد الكلاس هنا

class BannerCategoryController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;

    }
    public function index()
    {
        //
    }

    public function store(StoreBannerCategoryRequest $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $data = $request->validated();

        $category = Category::findOrFail($data['banner_categorys_category']);

        $imageResult = $this->uploadService->upload($request->file('banner_categorys_image'), 'bannercategory');
        if ($imageResult['status'] !== 'success') {
            return ResponseHelper::fail('فشل في رفع الصور');
        }
        $data['banner_categorys_image'] = $imageResult['filename'];
        $banner                         = $category->bannerCategories()->create($data);
        if ($banner) {
            return ResponseHelper::success(null, $banner, null, $imageResult['url']);
        }

        return ResponseHelper::fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $data =  $request->validate([
            'banner_categorys_category' => 'required|integer|exists:category,category_id',
        ]);
        $categoryId = $data['banner_categorys_category'];
        if (!$categoryId) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (items_category).');

        }
        $banners = BannerCategory::where('banner_categorys_category', $categoryId)->get();

        if ($banners->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $banners);

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdataBannerCategoryRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data           = $request->validated();
        $bannerCategory = BannerCategory::findOrFail($data['banner_categorys_id']);

        if ($request->hasFile('banner_categorys_image')) {
            try {
                $data['banner_categorys_image'] = $this->uploadService->imageUpdate(
                    $request->file('banner_categorys_image'),
                    'bannercategory',
                    $bannerCategory->banner_categorys_image,
                    2, // الحجم الأقصى بالميجابايت
                    ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }

        unset($data['banner_categorys_id']);
        $bannerCategory->update($data);

        return ResponseHelper::success(
            null,
            $bannerCategory,
            null,
            null,
            'تم تعديل الفئة الإعلانية بنجاح.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Request $request)
    {
          $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        // تحقق من وجود الـ id في الطلب
        $request->validate([
            'id' => 'required|integer|exists:banner_categorys,banner_categorys_id',
        ]);

        // جلب القائمة حسب الـ id
        $bannerCategory = BannerCategory::find($request->id);

        if (!$bannerCategory) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $bannerCategory->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف  بنجاح (حذف ناعم).');

    }
}
