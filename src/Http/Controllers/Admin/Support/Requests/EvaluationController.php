<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportEvaluation;
use Jiny\Site\Models\SiteSupportMultipleAssignment;

/**
 * 기술지원 평가 관리 컨트롤러
 */
class EvaluationController extends Controller
{
    /**
     * 평가 목록 조회
     */
    public function index(Request $request, $supportId)
    {
        try {
            $support = SiteSupport::findOrFail($supportId);

            $evaluations = SiteSupportEvaluation::where('support_id', $supportId)
                ->with(['evaluator', 'evaluatedAdmin'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'evaluations' => $evaluations->map(function ($evaluation) {
                        return [
                            'id' => $evaluation->id,
                            'evaluator' => $evaluation->is_anonymous ? '익명' : ($evaluation->evaluator ? [
                                'id' => $evaluation->evaluator->id,
                                'name' => $evaluation->evaluator->name
                            ] : null),
                            'evaluated_admin' => [
                                'id' => $evaluation->evaluatedAdmin->id,
                                'name' => $evaluation->evaluatedAdmin->name
                            ],
                            'rating' => $evaluation->rating,
                            'rating_label' => $evaluation->rating_label,
                            'rating_class' => $evaluation->rating_class,
                            'stars_html' => $evaluation->stars_html,
                            'comment' => $evaluation->comment,
                            'criteria_scores' => $evaluation->criteria_scores,
                            'is_anonymous' => $evaluation->is_anonymous,
                            'created_at' => $evaluation->created_at->format('Y-m-d H:i:s')
                        ];
                    })
                ]);
            }

            return view('jiny-site::admin.support.evaluations.index', [
                'support' => $support,
                'evaluations' => $evaluations
            ]);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '평가 목록 조회 중 오류가 발생했습니다: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['message' => '평가 목록 조회 중 오류가 발생했습니다.']);
        }
    }

    /**
     * 평가 작성 폼 표시
     */
    public function create($supportId)
    {
        try {
            $support = SiteSupport::with(['user', 'replies.user'])
                ->findOrFail($supportId);

            // 지원 요청의 소유자만 평가 가능
            if ($support->user_id !== Auth::id()) {
                return redirect()->back()->withErrors(['message' => '본인의 지원 요청만 평가할 수 있습니다.']);
            }

            // 이미 평가했는지 확인
            $existingEvaluation = SiteSupportEvaluation::where('support_id', $supportId)
                ->where('evaluator_id', Auth::id())
                ->first();

            if ($existingEvaluation) {
                return redirect()->back()->withErrors(['message' => '이미 이 지원 요청에 대해 평가를 작성했습니다.']);
            }

            // 평가 가능한 관리자 목록 (답변을 작성한 관리자들)
            $adminIds = $support->replies()
                ->where('sender_type', 'admin')
                ->distinct()
                ->pluck('user_id');

            $availableAdmins = \App\Models\User::whereIn('id', $adminIds)
                ->where('isAdmin', true)
                ->select('id', 'name', 'email')
                ->get();

            return view('jiny-site::admin.support.evaluations.create', [
                'support' => $support,
                'availableAdmins' => $availableAdmins
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['message' => '평가 페이지 로드 중 오류가 발생했습니다.']);
        }
    }

    /**
     * 평가 저장
     */
    public function store(Request $request, $supportId)
    {
        $request->validate([
            'evaluated_admin_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:2000',
            'criteria_scores' => 'nullable|array',
            'criteria_scores.*' => 'integer|between:1,5',
            'is_anonymous' => 'boolean'
        ]);

        try {
            $support = SiteSupport::findOrFail($supportId);

            // 지원 요청의 소유자만 평가 가능
            if ($support->user_id !== Auth::id()) {
                throw new \Exception('본인의 지원 요청만 평가할 수 있습니다.');
            }

            // 평가받을 관리자가 실제로 이 지원에 참여했는지 확인
            $evaluatedAdminId = $request->evaluated_admin_id;
            $hasParticipated = $support->replies()
                ->where('sender_type', 'admin')
                ->where('user_id', $evaluatedAdminId)
                ->exists();

            if (!$hasParticipated) {
                throw new \Exception('이 지원 요청에 참여하지 않은 관리자는 평가할 수 없습니다.');
            }

            // 평가 생성
            $evaluation = SiteSupportEvaluation::createEvaluation(
                $supportId,
                Auth::id(),
                $evaluatedAdminId,
                $request->rating,
                $request->comment,
                $request->criteria_scores,
                $request->boolean('is_anonymous', false)
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '평가가 성공적으로 저장되었습니다.',
                    'evaluation' => [
                        'id' => $evaluation->id,
                        'rating' => $evaluation->rating,
                        'rating_label' => $evaluation->rating_label
                    ]
                ]);
            }

            return redirect()
                ->route('admin.cms.support.requests.show', $supportId)
                ->with('success', '평가가 성공적으로 저장되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()
                ->withInput()
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 평가 상세 조회
     */
    public function show($supportId, $evaluationId)
    {
        try {
            $evaluation = SiteSupportEvaluation::with(['evaluator', 'evaluatedAdmin', 'support'])
                ->where('support_id', $supportId)
                ->findOrFail($evaluationId);

            return response()->json([
                'success' => true,
                'evaluation' => [
                    'id' => $evaluation->id,
                    'evaluator' => $evaluation->is_anonymous ? '익명' : ($evaluation->evaluator ? [
                        'id' => $evaluation->evaluator->id,
                        'name' => $evaluation->evaluator->name
                    ] : null),
                    'evaluated_admin' => [
                        'id' => $evaluation->evaluatedAdmin->id,
                        'name' => $evaluation->evaluatedAdmin->name
                    ],
                    'rating' => $evaluation->rating,
                    'rating_label' => $evaluation->rating_label,
                    'rating_class' => $evaluation->rating_class,
                    'stars_html' => $evaluation->stars_html,
                    'comment' => $evaluation->comment,
                    'criteria_scores' => $evaluation->criteria_scores,
                    'is_anonymous' => $evaluation->is_anonymous,
                    'created_at' => $evaluation->created_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '평가 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 관리자별 평가 통계 조회
     */
    public function getAdminStats(Request $request, $adminId = null)
    {
        try {
            if (!$adminId) {
                $adminId = Auth::id();
            }

            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // 기본 통계
            $stats = SiteSupportEvaluation::getAdminStats($adminId, $startDate, $endDate);

            // 세부 기준별 통계
            $criteriaStats = SiteSupportEvaluation::getCriteriaStats($adminId, $startDate, $endDate);

            // 최근 평가들
            $recentEvaluations = SiteSupportEvaluation::where('evaluated_admin_id', $adminId)
                ->with(['evaluator', 'support'])
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'criteria_stats' => $criteriaStats,
                'recent_evaluations' => $recentEvaluations->map(function ($evaluation) {
                    return [
                        'id' => $evaluation->id,
                        'support_id' => $evaluation->support_id,
                        'support_subject' => $evaluation->support->subject,
                        'evaluator' => $evaluation->is_anonymous ? '익명' : ($evaluation->evaluator ? $evaluation->evaluator->name : '알 수 없음'),
                        'rating' => $evaluation->rating,
                        'rating_label' => $evaluation->rating_label,
                        'comment' => $evaluation->comment ? \Str::limit($evaluation->comment, 100) : null,
                        'created_at' => $evaluation->created_at->format('Y-m-d H:i:s')
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '통계 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 전체 관리자 평가 랭킹 조회
     */
    public function getRanking(Request $request)
    {
        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $limit = $request->get('limit', 10);

            $ranking = SiteSupportEvaluation::getAdminRanking($startDate, $endDate, $limit);

            return response()->json([
                'success' => true,
                'ranking' => $ranking->map(function ($item) {
                    return [
                        'admin' => [
                            'id' => $item->evaluatedAdmin->id,
                            'name' => $item->evaluatedAdmin->name,
                            'email' => $item->evaluatedAdmin->email
                        ],
                        'total_evaluations' => $item->total_evaluations,
                        'average_rating' => round($item->average_rating, 2),
                        'total_score' => $item->total_score
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '랭킹 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}