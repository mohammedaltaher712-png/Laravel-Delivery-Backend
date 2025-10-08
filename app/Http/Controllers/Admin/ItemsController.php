<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\StoreItemsRequest;
use App\Http\Requests\Admin\Items\UpdataItemsRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\UploadService;
use Illuminate\Support\Facades\Storage;
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

    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function store(StoreItemsRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب التصنيف المرتبط
        $items = Category::findOrFail($data['items_category']);

        $imageResult = $this->uploadService->upload($request->file('items_image'), 'itemsimage');
        if ($imageResult['status'] !== 'success') {
            return ResponseHelper::fail('فشل في رفع الصور');
        }
        $data['items_image'] = $imageResult['filename'];
        // إنشاء البانر عبر علاقة التصنيف
        $item = $items->items()->create($data);
        if ($item) {
            return ResponseHelper::success(null, $item, null, $imageResult['url']);

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
          'items_category' => 'required|integer|exists:category,category_id',
        ]);
        $items_category = $data['items_category'];
        if (!$items_category) {
            return ResponseHelper::fail(null, 'يجب تحديد معرف التصنيف (items_category).');

        }
        $Service = Item::withTrashed()
            ->where('items_category', $items_category)
            ->get();

        if ($Service->isEmpty()) {
            return ResponseHelper::fail(null, 'لا توجد بانرات لهذا التصنيف.');

        }

        return ResponseHelper::success(null, $Service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataItemsRequest $request)
    {
        $admin = $request->user();

        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');

        }
        $data = $request->validated();
        $id   = $data['items_id'];

        $items = Item::findOrFail($id);

        if ($request->hasFile('items_image')) {
            try {
                $data['items_image'] = $this->uploadService->imageUpdate(
                    $request->file('items_image'),
                    'itemsimage',
                    $items->items_image
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }
        unset($data['items_id']);

        $items->update($data);

        return ResponseHelper::success(
            null,
            $items,
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
            'id' => 'required|integer|exists:items,items_id',
        ]);

        // جلب القائمة حسب الـ id
        $items = Item::find($request->id);

        if (!$items) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $items->delete();

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
        $items = Item::onlyTrashed()->find($request->id);

        if (!$items) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة أو ليست محذوفة.');

        }

        // استرجاع القائمة
        $items->restore();

        return ResponseHelper::success(
            null,
            $items,
            null,
            null,
            'تم استرجاع القائمة بنجاح.'
        );

    }
     public function search(Request $request)
    {
       $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        } 

        $data = $request->validate([
            'query' => 'required|string|min:1'
        ]);

        $searchTerm = $data['query'];

        // تنفيذ الاستعلام والبحث
        $Item = Item::where('items_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($Item->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $Item, null, null, null, 'تم جلب البيانات بنجاح.');
    }
}
