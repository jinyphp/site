<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Product Images 업로드 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_images',
            'upload_path' => 'products/images',
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'max_file_size' => 5 * 1024 * 1024, // 5MB
        ];
    }

    public function __invoke(Request $request, $productId)
    {
        // 상품 존재 확인
        $product = DB::table('site_products')
            ->where('id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product를 찾을 수 없습니다.'
            ], 404);
        }

        // 유효성 검사
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'image_type' => 'nullable|string|in:main,detail,lifestyle,tech_spec,packaging,comparison,installation,accessories',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'enable' => 'nullable|boolean',
        ]);

        $uploadedImages = [];
        $errors = [];

        // 현재 최대 위치 조회
        $maxPos = DB::table($this->config['table'])
            ->where('product_id', $productId)
            ->max('pos') ?? 0;

        try {
            DB::beginTransaction();

            foreach ($request->file('images') as $index => $file) {
                try {
                    // 파일 정보
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $mimeType = $file->getMimeType();
                    $fileSize = $file->getSize();

                    // 파일명 생성
                    $filename = $this->generateUniqueFilename($originalName, $extension);

                    // 이미지 크기 정보
                    $imageInfo = getimagesize($file->getPathname());
                    $dimensions = $imageInfo ? $imageInfo[0] . 'x' . $imageInfo[1] : null;

                    // 파일 업로드
                    $path = $file->storeAs($this->config['upload_path'], $filename, 'public');
                    $imageUrl = Storage::url($path);

                    // 썸네일 생성 (선택적)
                    $thumbnailUrl = $this->createThumbnail($file, $filename);

                    // 대표 이미지 설정 처리
                    $isFeatured = $request->boolean('is_featured') && $index === 0;

                    if ($isFeatured) {
                        // 기존 대표 이미지 해제
                        DB::table($this->config['table'])
                            ->where('product_id', $productId)
                            ->update(['is_featured' => false]);
                    }

                    // 데이터베이스 저장
                    $imageId = DB::table($this->config['table'])->insertGetId([
                        'product_id' => $productId,
                        'enable' => $request->boolean('enable', true),
                        'pos' => ++$maxPos,
                        'is_featured' => $isFeatured,
                        'title' => $request->input('title'),
                        'description' => $request->input('description'),
                        'alt_text' => $request->input('alt_text'),
                        'image_url' => $imageUrl,
                        'thumbnail_url' => $thumbnailUrl,
                        'original_filename' => $originalName,
                        'file_size' => $fileSize,
                        'dimensions' => $dimensions,
                        'mime_type' => $mimeType,
                        'tags' => $request->input('tags'),
                        'image_type' => $request->input('image_type', 'main'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $uploadedImages[] = [
                        'id' => $imageId,
                        'filename' => $filename,
                        'url' => $imageUrl,
                    ];

                } catch (\Exception $e) {
                    $errors[] = "파일 '{$originalName}' 업로드 실패: " . $e->getMessage();
                }
            }

            if (empty($uploadedImages)) {
                throw new \Exception('업로드된 이미지가 없습니다.');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . '개의 이미지가 성공적으로 업로드되었습니다.',
                'data' => [
                    'uploaded' => $uploadedImages,
                    'errors' => $errors,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            // 업로드된 파일들 삭제
            foreach ($uploadedImages as $image) {
                $this->deleteUploadedFile($image['filename']);
            }

            return response()->json([
                'success' => false,
                'message' => '이미지 업로드 중 오류가 발생했습니다: ' . $e->getMessage(),
                'errors' => $errors,
            ], 500);
        }
    }

    /**
     * 고유한 파일명 생성
     */
    private function generateUniqueFilename($originalName, $extension)
    {
        $basename = pathinfo($originalName, PATHINFO_FILENAME);
        $basename = Str::slug($basename);

        return $basename . '_' . time() . '_' . Str::random(8) . '.' . $extension;
    }

    /**
     * 썸네일 생성
     */
    private function createThumbnail($file, $filename)
    {
        try {
            // 썸네일 크기
            $thumbWidth = 300;
            $thumbHeight = 300;

            $thumbnailName = 'thumb_' . $filename;
            $thumbnailPath = $this->config['upload_path'] . '/thumbnails/' . $thumbnailName;

            // 디렉토리 생성
            $thumbnailDir = dirname(storage_path('app/public/' . $thumbnailPath));
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }

            // 이미지 리사이즈 (intervention/image 패키지 사용 권장)
            // 여기서는 기본 GD 라이브러리 사용
            $imageInfo = getimagesize($file->getPathname());

            if (!$imageInfo) {
                return null;
            }

            $srcWidth = $imageInfo[0];
            $srcHeight = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // 원본 이미지 로드
            switch ($mimeType) {
                case 'image/jpeg':
                    $srcImage = imagecreatefromjpeg($file->getPathname());
                    break;
                case 'image/png':
                    $srcImage = imagecreatefrompng($file->getPathname());
                    break;
                case 'image/webp':
                    $srcImage = imagecreatefromwebp($file->getPathname());
                    break;
                default:
                    return null;
            }

            if (!$srcImage) {
                return null;
            }

            // 비율 계산
            $ratio = min($thumbWidth / $srcWidth, $thumbHeight / $srcHeight);
            $newWidth = intval($srcWidth * $ratio);
            $newHeight = intval($srcHeight * $ratio);

            // 썸네일 생성
            $thumbImage = imagecreatetruecolor($newWidth, $newHeight);

            // PNG 투명도 처리
            if ($mimeType === 'image/png') {
                imagealphablending($thumbImage, false);
                imagesavealpha($thumbImage, true);
                $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
                imagefill($thumbImage, 0, 0, $transparent);
            }

            imagecopyresampled(
                $thumbImage, $srcImage,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $srcWidth, $srcHeight
            );

            // 썸네일 저장
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

            switch ($mimeType) {
                case 'image/jpeg':
                    imagejpeg($thumbImage, $fullThumbnailPath, 85);
                    break;
                case 'image/png':
                    imagepng($thumbImage, $fullThumbnailPath, 6);
                    break;
                case 'image/webp':
                    imagewebp($thumbImage, $fullThumbnailPath, 85);
                    break;
            }

            // 메모리 해제
            imagedestroy($srcImage);
            imagedestroy($thumbImage);

            return Storage::url($thumbnailPath);

        } catch (\Exception $e) {
            // 썸네일 생성 실패해도 원본 업로드는 계속 진행
            return null;
        }
    }

    /**
     * 업로드된 파일 삭제
     */
    private function deleteUploadedFile($filename)
    {
        try {
            $filePath = $this->config['upload_path'] . '/' . $filename;
            $thumbnailPath = $this->config['upload_path'] . '/thumbnails/thumb_' . $filename;

            Storage::disk('public')->delete($filePath);
            Storage::disk('public')->delete($thumbnailPath);
        } catch (\Exception $e) {
            // 삭제 실패해도 무시
        }
    }
}