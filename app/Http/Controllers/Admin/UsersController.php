<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdataUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
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
        $admin = $request->user();
        if (!$admin || !$request->user()->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }
        $show = User::all();

        return ResponseHelper::success(null, $show);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdataUsersRequest $request)
    {

        $admin = $request->user();

        // التحقق من أن المستخدم أدمن
        if (!$admin || !$admin->tokenCan('admin')) {
            return ResponseHelper::unauthorized('يجب تسجيل الدخول كأدمن أولاً.');
        }

        $data = $request->validated();

        // جلب مزود الخدمة باستخدام ID
        $users = User::find($data['users_id']);

        if (!$users) {
            return ResponseHelper::fail('مزود الخدمة غير موجود.');
        }

        // تحديث الحقول إذا كانت موجودة في الطلب
        if (isset($data['users_name'])) {
            $users->users_name = $data['users_name'];
        }

        if (isset($data['users_email'])) {
            $users->users_email = $data['users_email'];
        }

        if (isset($data['users_phone'])) {
            $users->users_phone = $data['users_phone'];
        }

        if (isset($data['users_password'])) {
            $users->users_password = bcrypt($data['users_password']);
        }

        // حفظ التغييرات
        $users->save();

        return ResponseHelper::success($users, 'تم التحديث بنجاح');
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
        $User = User::where('users_name', 'LIKE', "%{$searchTerm}%")

            ->get();

        if ($User->isEmpty()) {
            return ResponseHelper::fail(null, 'لم يتم العثور على خدمات مطابقة.');
        }

        return ResponseHelper::success(null, $User, null, null, null, 'تم جلب البيانات بنجاح.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
