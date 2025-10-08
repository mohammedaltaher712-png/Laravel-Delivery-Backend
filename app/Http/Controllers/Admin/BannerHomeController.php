<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerHomeStoreRequest;
use App\Http\Requests\Admin\bannnerHome\BannerHomeUpdataRequest;
use App\Models\BannerHome;
use App\Services\UploadService;
use Illuminate\Http\Request;

class BannerHomeController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function index()
    {
       
    }

    public function store(BannerHomeStoreRequest $request)
    {
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $data        = $request->validated();
        $imageResult = $this->uploadService->upload($request->file('banner_homes_image'), 'bannerhome');
        if ($imageResult['status'] !== 'success') {
            return ResponseHelper::fail('فشل في رفع الصور');
        }
        $data['banner_homes_image'] = $imageResult['filename'];
        $bannerhome                 = BannerHome::create($data);
        if ($bannerhome) {
            return ResponseHelper::success(null, $bannerhome, null, $imageResult['url']);
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
       $show = BannerHome::all();
      return ResponseHelper::success(null,$show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerHomeUpdataRequest $request)
    {
          $admin = $request->user();

        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data     = $request->validated();
        $BannerHome = BannerHome::findOrFail($data['banner_homes_id']);
          if ($request->hasFile('banner_homes_image')) {
            try {
                $data['banner_homes_image'] = $this->uploadService->imageUpdate(
                    $request->file('banner_homes_image'),
                    'bannerhome',
                    $BannerHome->banner_homes_image
                );
            } catch (\Exception $e) {
                return ResponseHelper::fail($e->getMessage());
            }
        }

        unset($data['banner_homes_id']);
        $BannerHome->update($data);

        return ResponseHelper::success(
            null,
            $BannerHome,
            null,
            null,
            'تم تعديل بنجاح.'
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
            'id' => 'required|integer|exists:banner_homes,banner_homes_id',
        ]);

        // جلب القائمة حسب الـ id
        $BannerHome = BannerHome::find($request->id);

        if (!$BannerHome) {
            return ResponseHelper::fail(null, 'القائمة غير موجودة.');

        }

        // تنفيذ الحذف الناعم
        $BannerHome->delete();

        return ResponseHelper::success(null, null, null, null, 'تم حذف  بنجاح (حذف ناعم).');

    }
}
