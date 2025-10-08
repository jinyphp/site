<?php

namespace Jiny\Site\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * 이미지 업로드 서비스
 */
class ImageUploadService
{
    /**
     * 파일 업로드
     *
     * @param UploadedFile $file
     * @param string $path
     * @return array
     */
    public function upload(UploadedFile $file, $path = 'images')
    {
        $filename = $this->generateFilename($file);
        $filepath = $path . '/' . $filename;

        // public 디스크에 저장
        $file->storeAs($path, $filename, 'public');

        return [
            'filename' => $filename,
            'path' => $filepath,
            'url' => Storage::disk('public')->url($filepath),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * 파일명 생성
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '_' . time() . '.' . $extension;

        return $filename;
    }
}
