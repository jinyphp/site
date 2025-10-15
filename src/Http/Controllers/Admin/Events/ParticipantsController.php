<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;
use Jiny\Site\Models\SiteEventUser;
use Illuminate\Http\JsonResponse;

/**
 * 이벤트 참여자 관리 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/event/{id}/participants') → ParticipantsController::index()
 */
class ParticipantsController extends BaseController
{
    /**
     * 참여자 목록 조회
     *
     * @param Request $request
     * @param int $id 이벤트 ID
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $id)
    {
        // 이벤트 조회
        $event = SiteEvent::findOrFail($id);

        // 참여자 목록 조회 (필터링 및 페이징)
        $query = SiteEventUser::forEvent($id)->with(['user']);

        // 상태 필터
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // 검색 필터
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 정렬
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['created_at', 'name', 'email', 'status', 'approved_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $participants = $query->paginate(20);

        // 통계 계산
        $stats = [
            'total' => $event->total_participants,
            'approved' => $event->approved_participants,
            'pending' => $event->pending_participants,
            'rejected' => $event->rejected_participants,
        ];

        return view('jiny-site::admin.events.participants.index', compact(
            'event',
            'participants',
            'stats'
        ));
    }

    /**
     * 참여자 상세 조회
     *
     * @param int $eventId
     * @param int $participantId
     * @return \Illuminate\View\View
     */
    public function show($eventId, $participantId)
    {
        $event = SiteEvent::findOrFail($eventId);
        $participant = SiteEventUser::where('event_id', $eventId)
                                   ->where('id', $participantId)
                                   ->with(['user'])
                                   ->firstOrFail();

        return view('jiny-site::admin.events.participants.show', compact(
            'event',
            'participant'
        ));
    }

    /**
     * 참여자 승인
     *
     * @param Request $request
     * @param int $eventId
     * @param int $participantId
     * @return JsonResponse
     */
    public function approve(Request $request, $eventId, $participantId)
    {
        try {
            $event = SiteEvent::findOrFail($eventId);
            $participant = SiteEventUser::where('event_id', $eventId)
                                       ->where('id', $participantId)
                                       ->firstOrFail();

            // 이미 승인된 경우
            if ($participant->isApproved()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 승인된 참여자입니다.'
                ]);
            }

            // 참여 인원 제한 체크
            if ($event->max_participants && $event->approved_participants >= $event->max_participants) {
                return response()->json([
                    'success' => false,
                    'message' => '참여 인원이 제한을 초과했습니다.'
                ]);
            }

            // 승인 처리
            $approvedBy = auth()->user()->name ?? auth()->user()->email ?? 'admin';
            $participant->approve($approvedBy);

            return response()->json([
                'success' => true,
                'message' => '참여자가 승인되었습니다.',
                'participant' => $participant->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '승인 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 참여자 거부
     *
     * @param Request $request
     * @param int $eventId
     * @param int $participantId
     * @return JsonResponse
     */
    public function reject(Request $request, $eventId, $participantId)
    {
        try {
            $participant = SiteEventUser::where('event_id', $eventId)
                                       ->where('id', $participantId)
                                       ->firstOrFail();

            // 이미 거부된 경우
            if ($participant->isRejected()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 거부된 참여자입니다.'
                ]);
            }

            // 거부 처리
            $approvedBy = auth()->user()->name ?? auth()->user()->email ?? 'admin';
            $participant->reject($approvedBy);

            return response()->json([
                'success' => true,
                'message' => '참여자가 거부되었습니다.',
                'participant' => $participant->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '거부 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 참여자 취소
     *
     * @param Request $request
     * @param int $eventId
     * @param int $participantId
     * @return JsonResponse
     */
    public function cancel(Request $request, $eventId, $participantId)
    {
        try {
            $participant = SiteEventUser::where('event_id', $eventId)
                                       ->where('id', $participantId)
                                       ->firstOrFail();

            // 이미 취소된 경우
            if ($participant->isCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 취소된 참여자입니다.'
                ]);
            }

            // 취소 처리
            $participant->cancel();

            return response()->json([
                'success' => true,
                'message' => '참여가 취소되었습니다.',
                'participant' => $participant->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '취소 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 참여자 삭제
     *
     * @param Request $request
     * @param int $eventId
     * @param int $participantId
     * @return JsonResponse
     */
    public function destroy(Request $request, $eventId, $participantId)
    {
        try {
            $participant = SiteEventUser::where('event_id', $eventId)
                                       ->where('id', $participantId)
                                       ->firstOrFail();

            $participant->delete();

            return response()->json([
                'success' => true,
                'message' => '참여자가 삭제되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '삭제 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 대량 작업
     *
     * @param Request $request
     * @param int $eventId
     * @return JsonResponse
     */
    public function bulk(Request $request, $eventId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,cancel,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer'
        ]);

        try {
            $event = SiteEvent::findOrFail($eventId);
            $participants = SiteEventUser::where('event_id', $eventId)
                                        ->whereIn('id', $request->ids)
                                        ->get();

            if ($participants->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => '선택된 참여자가 없습니다.'
                ]);
            }

            $approvedBy = auth()->user()->name ?? auth()->user()->email ?? 'admin';
            $successCount = 0;

            foreach ($participants as $participant) {
                try {
                    switch ($request->action) {
                        case 'approve':
                            if (!$participant->isApproved()) {
                                // 참여 인원 제한 체크
                                if ($event->max_participants && $event->approved_participants >= $event->max_participants) {
                                    break; // 제한 초과 시 건너뛰기
                                }
                                $participant->approve($approvedBy);
                                $successCount++;
                            }
                            break;

                        case 'reject':
                            if (!$participant->isRejected()) {
                                $participant->reject($approvedBy);
                                $successCount++;
                            }
                            break;

                        case 'cancel':
                            if (!$participant->isCancelled()) {
                                $participant->cancel();
                                $successCount++;
                            }
                            break;

                        case 'delete':
                            $participant->delete();
                            $successCount++;
                            break;
                    }
                } catch (\Exception $e) {
                    // 개별 실패는 로그만 남기고 계속 진행
                    logger('Bulk action failed for participant ' . $participant->id . ': ' . $e->getMessage());
                }
            }

            $actionNames = [
                'approve' => '승인',
                'reject' => '거부',
                'cancel' => '취소',
                'delete' => '삭제'
            ];

            return response()->json([
                'success' => true,
                'message' => "{$successCount}명의 참여자가 {$actionNames[$request->action]}되었습니다."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '대량 작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 참여자 직접 등록 폼
     *
     * @param int $eventId
     * @return \Illuminate\View\View
     */
    public function create($eventId)
    {
        $event = SiteEvent::findOrFail($eventId);

        return view('jiny-site::admin.events.participants.create', compact('event'));
    }

    /**
     * 참여자 수정 폼
     *
     * @param int $eventId
     * @param int $participantId
     * @return \Illuminate\View\View
     */
    public function edit($eventId, $participantId)
    {
        $event = SiteEvent::findOrFail($eventId);
        $participant = SiteEventUser::where('event_id', $eventId)
                                   ->where('id', $participantId)
                                   ->with(['user'])
                                   ->firstOrFail();

        return view('jiny-site::admin.events.participants.edit', compact('event', 'participant'));
    }

    /**
     * 참여자 직접 등록 처리
     *
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $eventId)
    {
        $event = SiteEvent::findOrFail($eventId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        // 중복 신청 체크
        $exists = SiteEventUser::where('event_id', $eventId)
                               ->where('email', $validated['email'])
                               ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'email' => '이미 신청된 이메일입니다.'
            ]);
        }

        // 참여 인원 제한 체크 (승인 상태로 등록하는 경우)
        if ($validated['status'] === 'approved' &&
            $event->max_participants &&
            $event->approved_participants >= $event->max_participants) {
            return back()->withInput()->withErrors([
                'status' => '참여 인원이 제한을 초과했습니다.'
            ]);
        }

        try {
            $validated['event_id'] = $eventId;
            $validated['applied_at'] = now();

            if ($validated['status'] === 'approved') {
                $validated['approved_at'] = now();
                $validated['approved_by'] = auth()->user()->name ?? auth()->user()->email ?? 'admin';
            }

            SiteEventUser::create($validated);

            session()->flash('success', '참여자가 성공적으로 등록되었습니다.');

            return redirect()->route('admin.site.event.participants.index', $eventId);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => '참여자 등록 중 오류가 발생했습니다: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * 참여자 정보 수정 처리
     *
     * @param Request $request
     * @param int $eventId
     * @param int $participantId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $eventId, $participantId)
    {
        $event = SiteEvent::findOrFail($eventId);
        $participant = SiteEventUser::where('event_id', $eventId)
                                   ->where('id', $participantId)
                                   ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,cancelled'
        ]);

        // 이메일 중복 체크 (자신 제외)
        $exists = SiteEventUser::where('event_id', $eventId)
                               ->where('email', $validated['email'])
                               ->where('id', '!=', $participantId)
                               ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'email' => '이미 사용중인 이메일입니다.'
            ]);
        }

        // 참여 인원 제한 체크 (승인 상태로 변경하는 경우)
        if ($validated['status'] === 'approved' &&
            $participant->status !== 'approved' &&
            $event->max_participants &&
            $event->approved_participants >= $event->max_participants) {
            return back()->withInput()->withErrors([
                'status' => '참여 인원이 제한을 초과했습니다.'
            ]);
        }

        try {
            $oldStatus = $participant->status;

            // 상태가 변경되고 승인으로 변경되는 경우 승인 정보 업데이트
            if ($validated['status'] === 'approved' && $oldStatus !== 'approved') {
                $validated['approved_at'] = now();
                $validated['approved_by'] = auth()->user()->name ?? auth()->user()->email ?? 'admin';
            } elseif ($validated['status'] !== 'approved') {
                // 승인이 아닌 상태로 변경되는 경우 승인 정보 초기화
                $validated['approved_at'] = null;
                $validated['approved_by'] = null;
            }

            $participant->update($validated);

            session()->flash('success', '참여자 정보가 성공적으로 수정되었습니다.');

            return redirect()->route('admin.site.event.participants.index', $eventId);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => '참여자 정보 수정 중 오류가 발생했습니다: ' . $e->getMessage()
            ]);
        }
    }
}