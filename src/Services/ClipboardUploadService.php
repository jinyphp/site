<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\Storage;

/**
 * 클립보드 이미지 업로드 서비스
 */
class ClipboardUploadService
{
    /**
     * Base64 이미지 업로드
     *
     * @param string $base64Image
     * @param string $path
     * @return array
     */
    public function uploadFromBase64($base64Image, $path = 'clipboard')
    {
        // Base64 데이터 파싱
        $imageData = $this->parseBase64($base64Image);

        // 파일명 생성
        $filename = $this->generateFilename($imageData['extension']);
        $filepath = $path . '/' . $filename;

        // public 디스크에 저장
        Storage::disk('public')->put($filepath, $imageData['data']);

        return [
            'filename' => $filename,
            'path' => $filepath,
            'url' => Storage::disk('public')->url($filepath),
            'size' => strlen($imageData['data']),
            'mime_type' => $imageData['mime_type'],
        ];
    }

    /**
     * Base64 데이터 파싱
     *
     * @param string $base64Image
     * @return array
     */
    protected function parseBase64($base64Image)
    {
        // data:image/png;base64,... 형식 파싱
        preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches);

        $extension = $matches[1] ?? 'png';
        $mimeType = 'image/' . $extension;

        // Base64 데이터 디코딩
        $data = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64Image));

        return [
            'data' => $data,
            'extension' => $extension,
            'mime_type' => $mimeType,
        ];
    }

    /**
     * 파일명 생성
     *
     * @param string $extension
     * @return string
     */
    protected function generateFilename($extension)
    {
        return 'clipboard_' . uniqid() . '_' . time() . '.' . $extension;
    }
}
