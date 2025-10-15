<?php

namespace Jiny\Site\Api\Controllers\Upload;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\ImageUploadService;

/**
 * 이미지 업로드 API 컨트롤러
 *
 * 진입 경로:
 * Route::post('/api/upload/images') → ImagesController::__invoke()
 *     ├─ 1. validateRequest() - 요청 검증
 *     ├─ 2. uploadImage() - 이미지 업로드
 *     └─ 3. responseJson() - JSON 응답
 */
class ImagesController extends Controller
{
    protected $uploadService;
    protected $config;

    /**
     * 생성자
     *
     * @param ImageUploadService $uploadService
     */
    public function __construct(ImageUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'max_size' => config('site.upload.max_size', 5120), // KB
            'allowed_types' => config('site.upload.allowed_types', ['jpg', 'jpeg', 'png', 'gif', 'webp']),
            'path' => config('site.upload.path', 'images'),
        ];
    }

    /**
     * 이미지 업로드 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            // 1단계: 요청 검증
            $this->validateRequest($request);

            // 2단계: 이미지 업로드
            $result = $this->uploadImage($request);

            // 3단계: JSON 응답
            return $this->responseJson($result);

        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * [1단계] 요청 검증
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRequest(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:' . $this->config['max_size'],
                'mimes:' . implode(',', $this->config['allowed_types']),
            ],
            'path' => 'nullable|string',
        ]);
    }

    /**
     * [2단계] 이미지 업로드
     *
     * @param Request $request
     * @return array
     */
    protected function uploadImage(Request $request)
    {
        $file = $request->file('file');
        $path = $request->input('path', $this->config['path']);

        return $this->uploadService->upload($file, $path);
    }

    /**
     * [3단계] JSON 응답 (성공)
     *
     * @param array $result
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($result)
    {
        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * JSON 응답 (에러)
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseError($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
    }
}
