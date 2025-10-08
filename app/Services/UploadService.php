<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UploadService
{
    /**
     * رفع صورة إلى مجلد داخل storage/app/public
     */
    public function upload(UploadedFile $file, string $folder, int $maxSizeMB = 2, array $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowed)) {
            return ['status' => 'fail', 'message' => 'امتداد الملف غير مسموح'];
        }

        if ($file->getSize() > $maxSizeMB * 1048576) {
            return ['status' => 'fail', 'message' => 'حجم الملف كبير جدًا'];
        }

        $filename = Str::random(10) . '_' . time() . '.' . $extension;
        $path = $file->storeAs($folder, $filename, 'public');

        return [
            'status' => 'success',
            'filename' => $filename,
            'path' => $path,
            'url' => asset('storage/' . $path),
        ];
    }

    public function imageUpdate(
        UploadedFile $file,
        string $folder,
        ?string $oldImage = null,
        int $maxSizeMB = 2,
        array $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowed)) {
            throw new \Exception("نوع الملف غير مسموح به.");
        }

        if ($file->getSize() > $maxSizeMB * 1024 * 1024) {
            throw new \Exception("حجم الملف أكبر من المسموح به ({$maxSizeMB}MB).");
        }

        if ($oldImage && Storage::disk('public')->exists($folder . '/' . $oldImage)) {
            Storage::disk('public')->delete($folder . '/' . $oldImage);
        }

        // نفس نمط الاسم في دالة upload
        $filename = Str::random(10) . '_' . time() . '.' . $extension;

        $file->storeAs($folder, $filename, 'public');

        return $filename;
    }

    public function insert(Model $modelInstance, array $data, bool $asJson = true): mixed
    {
        try {
            $modelInstance->fill($data)->save();

            if ($asJson) {
                return response()->json(['status' => 'success', 'data' => $modelInstance]);
            }

            return $modelInstance;
        } catch (\Exception $e) {
            if ($asJson) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }

            return null;
        }
    }

}
