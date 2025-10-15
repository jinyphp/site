<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Jiny\Site\Models\SiteContact;
use Jiny\Site\Models\SiteContactType;
use Jiny\Site\Models\SiteContactComment;

class ContactController extends Controller
{
    /**
     * 기본 설정
     */
    protected $config = [
        'title' => '상담 관리',
        'subtitle' => '고객 상담 요청을 관리합니다'
    ];

    /**
     * 상담 요청 목록
     */
    public function index(Request $request)
    {
        $query = SiteContact::with(['contactType', 'user', 'assignedUser']);

        // 상태 필터
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // 상담 유형 필터
        if ($request->has('type') && !empty($request->type)) {
            $query->where('contact_type_id', $request->type);
        }

        // 우선순위 필터
        if ($request->has('priority') && !empty($request->priority)) {
            $query->where('priority', $request->priority);
        }

        // 담당자 필터
        if ($request->has('assignee') && !empty($request->assignee)) {
            $query->where('assigned_to', $request->assignee);
        }

        // 검색 필터
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contact_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 정렬
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['created_at', 'updated_at', 'status', 'priority', 'contact_number'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $contacts = $query->paginate(20);

        // 필터 옵션을 위한 데이터
        $contactTypes = SiteContactType::where('enable', true)->orderBy('sort_order')->get();
        $assignees = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        // 통계 데이터
        $stats = [
            'total' => SiteContact::count(),
            'pending' => SiteContact::where('status', 'pending')->count(),
            'processing' => SiteContact::where('status', 'processing')->count(),
            'completed' => SiteContact::where('status', 'completed')->count(),
            'my_assigned' => SiteContact::where('assigned_to', Auth::id())->whereIn('status', ['pending', 'processing'])->count(),
        ];

        return view('jiny-site::admin.contact.index', compact(
            'contacts',
            'contactTypes',
            'assignees',
            'stats'
        ))->with('config', $this->config);
    }

    /**
     * 상담 요청 상세 조회
     */
    public function show($id)
    {
        $contact = SiteContact::with(['contactType', 'user', 'assignedUser', 'comments.user'])
                              ->findOrFail($id);

        $assignees = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        // 통계 데이터
        $stats = [
            'total_contacts' => SiteContact::count(),
            'pending_contacts' => SiteContact::where('status', 'pending')->count(),
            'processing_contacts' => SiteContact::where('status', 'processing')->count(),
        ];

        return view('jiny-site::admin.contact.show', compact('contact', 'assignees', 'stats'));
    }

    /**
     * 상담 상태 변경
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $contact = SiteContact::findOrFail($id);

        $updateData = [
            'status' => $request->status
        ];

        // 담당자 할당
        if ($request->has('assigned_to')) {
            $updateData['assigned_to'] = $request->assigned_to;
        }

        // 상태가 완료/취소로 변경되는 경우 처리일 설정
        if (in_array($request->status, ['completed', 'cancelled'])) {
            $updateData['processed_at'] = now();
        }

        $contact->update($updateData);

        return response()->json([
            'success' => true,
            'message' => '상담 상태가 변경되었습니다.',
            'contact' => $contact->fresh(['contactType', 'assignedUser'])
        ]);
    }

    /**
     * 담당자 할당
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $contact = SiteContact::findOrFail($id);
        $contact->update([
            'assigned_to' => $request->assigned_to
        ]);

        return response()->json([
            'success' => true,
            'message' => '담당자가 할당되었습니다.',
            'contact' => $contact->fresh(['assignedUser'])
        ]);
    }

    /**
     * 댓글/답변 작성
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:5000',
            'is_internal' => 'boolean'
        ]);

        $contact = SiteContact::findOrFail($id);

        $comment = SiteContactComment::create([
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'is_internal' => $request->is_internal ?? false
        ]);

        // 공개 댓글인 경우 상담 상태를 처리 중으로 변경
        if (!$comment->is_internal && $contact->status === 'pending') {
            $contact->update(['status' => 'processing']);
        }

        return response()->json([
            'success' => true,
            'message' => $comment->is_internal ? '내부 메모가 추가되었습니다.' : '답변이 등록되었습니다.',
            'comment' => $comment->load('user')
        ]);
    }

    /**
     * 대량 작업
     */
    public function bulk(Request $request)
    {
        $request->validate([
            'action' => 'required|in:assign,status,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
            'value' => 'required_unless:action,delete'
        ]);

        try {
            $contacts = SiteContact::whereIn('id', $request->ids)->get();

            if ($contacts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => '선택된 상담이 없습니다.'
                ]);
            }

            $successCount = 0;

            foreach ($contacts as $contact) {
                try {
                    switch ($request->action) {
                        case 'assign':
                            $contact->update(['assigned_to' => $request->value]);
                            $successCount++;
                            break;

                        case 'status':
                            $updateData = ['status' => $request->value];
                            if (in_array($request->value, ['completed', 'cancelled'])) {
                                $updateData['processed_at'] = now();
                            }
                            $contact->update($updateData);
                            $successCount++;
                            break;

                        case 'delete':
                            $contact->delete();
                            $successCount++;
                            break;
                    }
                } catch (\Exception $e) {
                    // 개별 실패는 로그만 남기고 계속 진행
                    logger('Bulk action failed for contact ' . $contact->id . ': ' . $e->getMessage());
                }
            }

            $actionNames = [
                'assign' => '담당자 할당',
                'status' => '상태 변경',
                'delete' => '삭제'
            ];

            return response()->json([
                'success' => true,
                'message' => "{$successCount}건의 상담이 {$actionNames[$request->action]}되었습니다."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '대량 작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 상담 삭제
     */
    public function destroy($id)
    {
        $contact = SiteContact::findOrFail($id);
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => '상담이 삭제되었습니다.'
        ]);
    }

}