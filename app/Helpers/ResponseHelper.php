<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * استجابة ناجحة
     */
    public static function success( $data = null, $dataone = null,$count =null, $token = null, $url = null,$Messages= null,  $tot = null  ,int $status = 200 )
    {
        $response = [
            'status' => 'success',
            'message' => 'تم بنجاح',
         
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }
          if (!is_null($dataone)) {
            $response['data'] = $dataone;
        }
         if (!is_null($url)) {
            $response['url'] = $url;
        }
          if (!is_null($Messages)) {
            $response['Messages'] = $Messages;
        }
        if(!is_null($token)){

              $response['token'] = $token;
        }
          if(!is_null($count)){

              $response['count'] = $count;
        }
  if(!is_null($tot)){

              $response['tot'] = $tot;
        }
        return response()->json($response, $status);
    }

    /**
     * استجابة فاشلة
     */
    public static function fail( $errors = null,$Messages= null, int $status = 422)
    {
        $response = [
            'status' => 'fail',
            'message' => 'حدث خطأ ما',
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }
         if (!is_null($Messages)) {
            $response['Messages'] = $Messages;
        }

        return response()->json($response, $status);
    }
    public static function unauthorized(string $message = 'غير مصرح لك', int $status = 401)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message,
        ], $status);
    }
}
