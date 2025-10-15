<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportReply;

/**
 * 지원 요청 답변 컨트롤러
 */
class ReplyController extends Controller
{
    /**
     * 답변 저장
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'is_private' => 'boolean',
            'attachments' => 'array',
            'attachments.*' => 'file|max:10240', // 10MB 제한
        ]);

        try {
            $support = SiteSupport::findOrFail($id);

            // 첨부파일 처리
            $attachments = null;
            if ($request->hasFile('attachments')) {
                $attachments = $this->handleAttachments($request->file('attachments'));
            }

            // 답변 생성
            $reply = $support->addAdminReply(
                $request->input('content'),
                $request->boolean('is_private'),
                $attachments
            );

            // 지원 요청 상태를 처리중으로 변경 (대기중인 경우)
            if ($support->status === 'pending') {
                $support->update(['status' => 'in_progress']);
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '답변이 저장되었습니다.',
                    'reply' => $reply->load('user'),
                ]);
            }

            return redirect()
                ->route('admin.cms.support.requests.show', $id)
                ->with('success', '답변이 저장되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '답변 저장 중 오류가 발생했습니다: ' . $e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['content' => '답변 저장 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 답변 수정
     */
    public function update(Request $request, $supportId, $replyId)
    {
        $request->validate([
            'content' => 'required|string',
            'is_private' => 'boolean',
        ]);

        try {
            $support = SiteSupport::findOrFail($supportId);
            $reply = SiteSupportReply::where('support_id', $supportId)
                ->where('id', $replyId)
                ->firstOrFail();

            // 본인이 작성한 답변만 수정 가능
            if ($reply->user_id !== auth()->id()) {
                throw new \Exception('본인이 작성한 답변만 수정할 수 있습니다.');
            }

            $reply->update([
                'content' => $request->input('content'),
                'is_private' => $request->boolean('is_private'),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '답변이 수정되었습니다.',
                    'reply' => $reply->fresh()->load('user'),
                ]);
            }

            return redirect()
                ->route('admin.cms.support.requests.show', $supportId)
                ->with('success', '답변이 수정되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '답변 수정 중 오류가 발생했습니다: ' . $e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['content' => '답변 수정 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 답변 삭제
     */
    public function destroy(Request $request, $supportId, $replyId)
    {
        try {
            $support = SiteSupport::findOrFail($supportId);
            $reply = SiteSupportReply::where('support_id', $supportId)
                ->where('id', $replyId)
                ->firstOrFail();

            // 본인이 작성한 답변만 삭제 가능
            if ($reply->user_id !== auth()->id()) {
                throw new \Exception('본인이 작성한 답변만 삭제할 수 있습니다.');
            }

            // 첨부파일 삭제
            if ($reply->attachments) {
                $this->deleteAttachments($reply->attachments);
            }

            $reply->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '답변이 삭제되었습니다.',
                ]);
            }

            return redirect()
                ->route('admin.cms.support.requests.show', $supportId)
                ->with('success', '답변이 삭제되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '답변 삭제 중 오류가 발생했습니다: ' . $e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => '답변 삭제 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 답변 읽음 표시
     */
    public function markAsRead(Request $request, $supportId, $replyId)
    {
        try {
            $reply = SiteSupportReply::where('support_id', $supportId)
                ->where('id', $replyId)
                ->firstOrFail();

            $reply->markAsRead();

            return response()->json([
                'success' => true,
                'message' => '읽음으로 표시되었습니다.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '처리 중 오류가 발생했습니다: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * 전체 답변 목록 (AJAX)
     */
    public function list(Request $request, $id)
    {
        $support = SiteSupport::findOrFail($id);

        $replies = $support->replies()
            ->with(['user'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'replies' => $replies,
        ]);
    }

    /**
     * 첨부파일 처리
     */
    private function handleAttachments($files)
    {
        $attachments = [];

        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();

            // 파일명 중복 방지
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // storage/app/public/support/attachments 에 저장
            $path = $file->storeAs('support/attachments', $filename, 'public');

            $attachments[] = [
                'name' => $originalName,
                'filename' => $filename,
                'path' => $path,
                'size' => $size,
                'extension' => $extension,
                'uploaded_at' => now()->toDateTimeString(),
            ];
        }

        return $attachments;
    }

    /**
     * 첨부파일 삭제
     */
    private function deleteAttachments($attachments)
    {
        foreach ($attachments as $attachment) {
            if (isset($attachment['path'])) {
                \Storage::disk('public')->delete($attachment['path']);
            }
        }
    }

    /**
     * 첨부파일 다운로드
     */
    public function downloadAttachment(Request $request, $supportId, $replyId, $attachmentIndex)
    {
        try {
            $reply = SiteSupportReply::where('support_id', $supportId)
                ->where('id', $replyId)
                ->firstOrFail();

            if (!$reply->attachments || !isset($reply->attachments[$attachmentIndex])) {
                throw new \Exception('첨부파일을 찾을 수 없습니다.');
            }

            $attachment = $reply->attachments[$attachmentIndex];
            $filePath = storage_path('app/public/' . $attachment['path']);

            if (!file_exists($filePath)) {
                throw new \Exception('파일이 존재하지 않습니다.');
            }

            return response()->download($filePath, $attachment['name']);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => '파일 다운로드 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }
}