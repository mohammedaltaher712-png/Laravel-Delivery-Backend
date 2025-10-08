<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $show = Category::withTrashed()->get();

        return ResponseHelper::success(null, $show);

    }

    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function store(StoreCategoryRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        $imageResult = $this->uploadService->upload($request->file('category_image'), 'categoryimage');
        if ($imageResult['status'] !== 'success') {
            return ResponseHelper::fail('فشل في رفع الصور');
        }
        $data['category_image'] = $imageResult['filename'];
        $category               = Category::create($data);

        if ($category) {
            return ResponseHelper::success(null, $category, null, $imageResult['url']);

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
        $show = Category::all();

        return ResponseHelper::success(null, $show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data     = $request->validated();
        $category = Category::findOrFail($data['category_id']);

        if ($request->hasFile('category_image')) {
            try {
                $data['category_image'] = $this->uploadService->imageUpdate(
                    $request->file('category_image'),
                    'categoryimage',
                    $category->category_image
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }

        unset($data['category_id']);
        $category->update($data);

        return ResponseHelper::success(
            null,
            $category,
            null,
            null,
            'تم تعديل التصنيف بنجاح.'
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
        $request->validate([
            'id' => 'required|integer|exists:category,category_id',
        ]);

        // جلب القائمة حسب الـ id
        $Category = Category::find($request->id);

        if (!$Category) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $Category->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف القائمة بنجاح (حذف ناعم).');

    }
    public function restore(Request $request)
    {
        $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }        $request->validate([
            'id' => 'required|integer',
        ]);

        // جلب القائمة المحذوفة فقط (soft deleted)
        $Category = Category::onlyTrashed()->find($request->id);

        if (!$Category) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        // استرجاع القائمة
        $Category->restore();

        return ResponseHelper::success(
            null,
            $Category,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

    }
}
