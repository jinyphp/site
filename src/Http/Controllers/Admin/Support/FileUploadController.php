<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 파일 업로드 컨트롤러
 */
class FileUploadController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 파일 업로드 처리
     */
    public function upload(Request $request, $supportId)
    {
        $support = SiteSupport::findOrFail($supportId);

        $request->validate([
            'files.*' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip,rar', // 10MB 제한
        ]);

        if (!$request->hasFile('files')) {
            return response()->json(['success' => false, 'message' => '업로드할 파일이 없습니다.'], 400);
        }

        $uploadedFiles = [];
        $existingAttachments = $support->attachments ?? [];

        foreach ($request->file('files') as $file) {
            try {
                // 파일 정보 검증
                if (!$file->isValid()) {
                    continue;
                }

                // 안전한 파일명 생성
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $safeName = $this->generateSafeFileName($originalName, $extension);

                // 파일 저장
                $path = $file->storeAs(
                    'support/' . $supportId,
                    $safeName,
                    'public'
                );

                // 파일 정보 저장
                $fileInfo = [
                    'original_name' => $originalName,
                    'stored_name' => $safeName,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString(),
                    'uploaded_by' => $request->user()->id,
                ];

                $uploadedFiles[] = $fileInfo;

            } catch (\Exception $e) {
                \Log::error('File upload failed', [
                    'support_id' => $supportId,
                    'file_name' => $originalName ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
            }
        }

        if (empty($uploadedFiles)) {
            return response()->json(['success' => false, 'message' => '파일 업로드에 실패했습니다.'], 500);
        }

        // 기존 첨부파일과 병합
        $allAttachments = array_merge($existingAttachments, $uploadedFiles);

        // 데이터베이스 업데이트
        $support->update(['attachments' => $allAttachments]);

        // 활동 로그 기록
        \Log::info('Support files uploaded', [
            'support_id' => $supportId,
            'uploaded_count' => count($uploadedFiles),
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name
        ]);

        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . '개 파일이 업로드되었습니다.',
            'files' => $uploadedFiles
        ]);
    }

    /**
     * 파일 삭제
     */
    public function delete(Request $request, $supportId, $fileIndex)
    {
        $support = SiteSupport::findOrFail($supportId);
        $attachments = $support->attachments ?? [];

        if (!isset($attachments[$fileIndex])) {
            return response()->json(['success' => false, 'message' => '파일을 찾을 수 없습니다.'], 404);
        }

        $fileInfo = $attachments[$fileIndex];

        try {
            // 실제 파일 삭제
            if (isset($fileInfo['path']) && Storage::disk('public')->exists($fileInfo['path'])) {
                Storage::disk('public')->delete($fileInfo['path']);
            }

            // 배열에서 파일 정보 제거
            unset($attachments[$fileIndex]);
            $attachments = array_values($attachments); // 인덱스 재정렬

            // 데이터베이스 업데이트
            $support->update(['attachments' => $attachments]);

            // 활동 로그 기록
            \Log::info('Support file deleted', [
                'support_id' => $supportId,
                'file_name' => $fileInfo['original_name'] ?? 'unknown',
                'admin_id' => $request->user()->id,
                'admin_name' => $request->user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => '파일이 삭제되었습니다.'
            ]);

        } catch (\Exception $e) {
            \Log::error('File deletion failed', [
                'support_id' => $supportId,
                'file_index' => $fileIndex,
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false, 'message' => '파일 삭제에 실패했습니다.'], 500);
        }
    }

    /**
     * 파일 다운로드
     */
    public function download(Request $request, $supportId, $fileIndex)
    {
        $support = SiteSupport::findOrFail($supportId);
        $attachments = $support->attachments ?? [];

        if (!isset($attachments[$fileIndex])) {
            abort(404, '파일을 찾을 수 없습니다.');
        }

        $fileInfo = $attachments[$fileIndex];

        if (!isset($fileInfo['path']) || !Storage::disk('public')->exists($fileInfo['path'])) {
            abort(404, '파일이 존재하지 않습니다.');
        }

        // 다운로드 로그 기록
        \Log::info('Support file downloaded', [
            'support_id' => $supportId,
            'file_name' => $fileInfo['original_name'] ?? 'unknown',
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name
        ]);

        // 파일 다운로드
        return Storage::disk('public')->download(
            $fileInfo['path'],
            $fileInfo['original_name'] ?? 'download'
        );
    }

    /**
     * 첨부파일 목록 조회
     */
    public function list(Request $request, $supportId)
    {
        $support = SiteSupport::findOrFail($supportId);
        $attachments = $support->attachments ?? [];

        $fileList = [];
        foreach ($attachments as $index => $fileInfo) {
            $fileList[] = [
                'index' => $index,
                'original_name' => $fileInfo['original_name'] ?? 'unknown',
                'size' => $fileInfo['size'] ?? 0,
                'size_formatted' => $this->formatFileSize($fileInfo['size'] ?? 0),
                'mime_type' => $fileInfo['mime_type'] ?? 'unknown',
                'uploaded_at' => $fileInfo['uploaded_at'] ?? null,
                'uploaded_by' => $fileInfo['uploaded_by'] ?? null,
                'download_url' => route('admin.cms.support.file.download', [$supportId, $index]),
                'delete_url' => route('admin.cms.support.file.delete', [$supportId, $index]),
            ];
        }

        return response()->json([
            'success' => true,
            'files' => $fileList,
            'total_count' => count($fileList)
        ]);
    }

    /**
     * 안전한 파일명 생성
     */
    private function generateSafeFileName($originalName, $extension)
    {
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9가-힣._-]/', '_', $baseName);
        $safeName = substr($safeName, 0, 200); // 길이 제한

        // 고유성을 위해 타임스탬프 추가
        $timestamp = now()->format('YmdHis');

        return $safeName . '_' . $timestamp . '.' . $extension;
    }

    /**
     * 파일 크기 포맷팅
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}