<?php
namespace Jiny\Site\API\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadClip extends Controller
{
    /**
     * 클립보드 이미지 업로드
     */
    public function store(Request $request)
    {
        $path = $request->input('path');
        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => '업로드 경로가 없습니다.'
            ]);
        }


        $image = $request->file('image');
        try {
            // 원본 파일명 추출
            $originalName = $image->getClientOriginalName();

            // 파일 확장자 추출
            $extension = $image->getClientOriginalExtension();

            // 유니크한 파일명 생성
            $filename = time() . '_' . Str::random(10) . '.' . $extension;

            // 저장 경로 설정
            $uploadPath = public_path($path);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 파일 저장
            $image->move($uploadPath, $filename);

            return response()->json([
                'success' => true,
                'message' => '이미지 업로드 성공',
                //'code' => $code,
                'filename' => $filename,
                //'id' => $id,
                'originalName' => $originalName,
                'extension' => $extension,
                'url' => $path.'/'.$filename
            ]);

            return response()->json([
                'success' => true,
                'message' => '이미지 업로드 성공',
                'code' => $request->input('code'),
                'id' => $request->input('id'),
                //'filename' => $originalName,
                // 'url' => $request->file('image')->store('images', 'public'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '이미지 저장 중 오류가 발생했습니다: ' . $e->getMessage()
            ]);
        }
    }
}
