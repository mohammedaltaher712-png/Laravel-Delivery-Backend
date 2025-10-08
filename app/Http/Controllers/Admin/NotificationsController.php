<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  public function Notifications(Request $request)
{
    // التحقق من أن البيانات موجودة
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // جلب البيانات من الطلب
    $title = $request->input('title');
    $message = $request->input('message');

    // اسم التوبيك
    $topic = "users";

    // إرسال الإشعار
    $this->firebase->sendToTopic(
        $topic,
        $title,
        $message,
        "none",
        "refreshorderpending"
    );

    return response()->json(['status' => 'success', 'message' => 'تم إرسال الإشعار بنجاح']);
}

    

   
}
