<?php

namespace Jiny\Site\Http\Controllers\Site\Event;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Jiny\Site\Models\SiteEvent;
use Jiny\Site\Models\SiteEventUser;

class ParticipateController
{
    /**
     * 참여 신청 폼 표시
     */
    public function show(Request $request, int $id)
    {
        $event = SiteEvent::findOrFail($id);

        // 참여 신청이 비활성화된 경우
        if (!$event->allow_participation) {
            abort(404, '참여 신청을 받지 않는 이벤트입니다.');
        }

        // 참여 신청이 불가능한 경우
        if (!$event->canParticipate()) {
            $message = '참여 신청이 불가능합니다.';
            if ($event->isParticipationClosed()) {
                $message = '참여 신청이 마감되었습니다.';
            } elseif ($event->participation_start_date && now()->lt($event->participation_start_date)) {
                $message = '참여 신청이 아직 시작되지 않았습니다.';
            }

            return redirect()->route('event.show', $event->id)
                           ->with('error', $message);
        }

        // 이미 참여 신청한 경우 확인
        $userEmail = auth()->user()->email ?? session('guest_email') ?? null;
        if ($userEmail && $event->hasParticipated($userEmail)) {
            return redirect()->route('event.show', $event->id)
                           ->with('info', '이미 참여 신청하셨습니다.');
        }

        return view('jiny-site::site.event.participate', compact('event'));
    }

    /**
     * 참여 신청 처리
     */
    public function store(Request $request, int $id)
    {
        $event = SiteEvent::findOrFail($id);

        // 참여 신청이 비활성화된 경우
        if (!$event->allow_participation) {
            abort(404, '참여 신청을 받지 않는 이벤트입니다.');
        }

        // 참여 신청이 불가능한 경우
        if (!$event->canParticipate()) {
            throw ValidationException::withMessages([
                'event' => ['참여 신청이 불가능합니다.']
            ]);
        }

        // 유효성 검사
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => '이름을 입력해주세요.',
            'email.required' => '이메일을 입력해주세요.',
            'email.email' => '올바른 이메일 형식을 입력해주세요.',
            'phone.max' => '전화번호는 20자 이내로 입력해주세요.',
            'message.max' => '메시지는 1000자 이내로 입력해주세요.',
        ]);

        // 중복 신청 확인
        if ($event->hasParticipated($validated['email'])) {
            throw ValidationException::withMessages([
                'email' => ['이미 참여 신청한 이메일입니다.']
            ]);
        }

        // 다시 한번 참여 가능 여부 확인 (동시성 처리)
        if (!$event->canParticipate()) {
            throw ValidationException::withMessages([
                'event' => ['참여 신청이 마감되었습니다.']
            ]);
        }

        // 참여 신청 생성
        $participation = SiteEventUser::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => $event->approval_type === 'auto' ? 'approved' : 'pending',
            'applied_at' => now(),
            'approved_at' => $event->approval_type === 'auto' ? now() : null,
            'approved_by' => $event->approval_type === 'auto' ? 'system' : null,
        ]);

        // 세션에 이메일 저장 (비회원의 경우)
        if (!auth()->check()) {
            session(['guest_email' => $validated['email']]);
        }

        $message = $event->approval_type === 'auto'
            ? '참여 신청이 완료되었습니다!'
            : '참여 신청이 접수되었습니다. 승인 결과를 기다려주세요.';

        return redirect()->route('event.show', $event->id)
                        ->with('success', $message);
    }

    /**
     * 참여 신청 취소
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $event = SiteEvent::findOrFail($id);

        $userEmail = auth()->user()->email ?? session('guest_email') ?? null;
        if (!$userEmail) {
            return response()->json([
                'success' => false,
                'message' => '로그인이 필요합니다.'
            ], 401);
        }

        $participation = $event->getParticipation($userEmail);
        if (!$participation) {
            return response()->json([
                'success' => false,
                'message' => '참여 신청 기록을 찾을 수 없습니다.'
            ], 404);
        }

        // 취소 불가능한 상태 확인
        if ($participation->isRejected() || $participation->isCancelled()) {
            return response()->json([
                'success' => false,
                'message' => '이미 취소되었거나 거부된 신청입니다.'
            ], 400);
        }

        // 참여 신청 취소
        $participation->cancel();

        return response()->json([
            'success' => true,
            'message' => '참여 신청이 취소되었습니다.'
        ]);
    }

    /**
     * 참여 신청 현황 조회 (AJAX)
     */
    public function status(Request $request, int $id): JsonResponse
    {
        $event = SiteEvent::findOrFail($id);

        $userEmail = auth()->user()->email ?? session('guest_email') ?? null;
        $participation = $userEmail ? $event->getParticipation($userEmail) : null;

        $data = [
            'event_id' => $event->id,
            'allow_participation' => $event->allow_participation,
            'can_participate' => $event->canParticipate(),
            'is_participation_closed' => $event->isParticipationClosed(),
            'max_participants' => $event->max_participants,
            'approved_count' => $event->approvedParticipants()->count(),
            'pending_count' => $event->pendingParticipants()->count(),
            'remaining_spots' => $event->getRemainingSpots(),
            'participation_rate' => $event->getParticipationRate(),
            'participation_start_date' => $event->participation_start_date?->toISOString(),
            'participation_end_date' => $event->participation_end_date?->toISOString(),
        ];

        if ($participation) {
            $data['user_participation'] = [
                'id' => $participation->id,
                'status' => $participation->status,
                'status_text' => $participation->status_text,
                'applied_at' => $participation->applied_at->toISOString(),
                'approved_at' => $participation->approved_at?->toISOString(),
            ];
        }

        return response()->json($data);
    }
}