<?php

namespace Jiny\Site\Api\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\ClipboardUploadService;

/**
 * 클립보드 이미지 업로드 API 컨트롤러
 *
 * 진입 경로:
 * Route::post('/api/upload/clip') → ClipController::__invoke()
 *     ├─ 1. validateRequest() - 요청 검증
 *     ├─ 2. uploadClipboardImage() - 클립보드 이미지 업로드
 *     └─ 3. responseJson() - JSON 응답
 */
class ClipController extends Controller
{
    protected $uploadService;
    protected $config;

    /**
     * 생성자
     *
     * @param ClipboardUploadService $uploadService
     */
    public function __construct(ClipboardUploadService $uploadService)
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
            'max_size' => config('site.upload.clipboard.max_size', 5120), // KB
            'path' => config('site.upload.clipboard.path', 'clipboard'),
        ];
    }

    /**
     * 클립보드 이미지 업로드 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            // 1단계: 요청 검증
            $this->validateRequest($request);

            // 2단계: 클립보드 이미지 업로드
            $result = $this->uploadClipboardImage($request);

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
            'image' => 'required|string', // Base64 이미지
        ]);
    }

    /**
     * [2단계] 클립보드 이미지 업로드
     *
     * @param Request $request
     * @return array
     */
    protected function uploadClipboardImage(Request $request)
    {
        $base64Image = $request->input('image');

        return $this->uploadService->uploadFromBase64($base64Image, $this->config['path']);
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
