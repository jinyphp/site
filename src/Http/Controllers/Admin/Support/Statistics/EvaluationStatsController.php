<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Statistics;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupportEvaluation;
use App\Models\User;

/**
 * 관리자 평가 통계 대시보드 컨트롤러
 */
class EvaluationStatsController extends Controller
{
    /**
     * 평가 통계 대시보드
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $adminId = $request->input('admin_id', Auth::id());

        // 관리자 권한 확인 (본인 또는 상위 관리자만 조회 가능)
        if ($adminId !== Auth::id() && !$this->canViewOtherAdminStats()) {
            $adminId = Auth::id();
        }

        $admin = User::where('isAdmin', true)->findOrFail($adminId);

        // 기본 통계
        $stats = SiteSupportEvaluation::getAdminStats($adminId, $startDate, $endDate);

        // 세부 기준별 통계
        $criteriaStats = SiteSupportEvaluation::getCriteriaStats($adminId, $startDate, $endDate);

        // 시간별 트렌드 (최근 12개월)
        $trends = $this->getEvaluationTrends($adminId, $startDate, $endDate);

        // 최근 평가들
        $recentEvaluations = SiteSupportEvaluation::where('evaluated_admin_id', $adminId)
            ->with(['evaluator', 'support'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 전체 관리자 중 순위
        $ranking = $this->getAdminRanking($adminId, $startDate, $endDate);

        // 관리자 목록 (드롭다운용)
        $admins = User::where('isAdmin', true)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('jiny-site::admin.support.statistics.evaluations', [
            'admin' => $admin,
            'stats' => $stats,
            'criteriaStats' => $criteriaStats,
            'trends' => $trends,
            'recentEvaluations' => $recentEvaluations,
            'ranking' => $ranking,
            'admins' => $admins,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'selectedAdminId' => $adminId,
        ]);
    }

    /**
     * 관리자 랭킹 페이지
     */
    public function ranking(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $limit = $request->input('limit', 20);

        $rankings = SiteSupportEvaluation::getAdminRanking($startDate, $endDate, $limit);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'rankings' => $rankings->map(function ($item) {
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
        }

        return view('jiny-site::admin.support.statistics.ranking', [
            'rankings' => $rankings,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'limit' => $limit,
        ]);
    }

    /**
     * 평가 통계 API (AJAX용)
     */
    public function getStats(Request $request, $adminId = null)
    {
        if (!$adminId) {
            $adminId = Auth::id();
        }

        // 권한 확인
        if ($adminId !== Auth::id() && !$this->canViewOtherAdminStats()) {
            return response()->json([
                'success' => false,
                'message' => '접근 권한이 없습니다.'
            ], 403);
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        try {
            $stats = SiteSupportEvaluation::getAdminStats($adminId, $startDate, $endDate);
            $criteriaStats = SiteSupportEvaluation::getCriteriaStats($adminId, $startDate, $endDate);
            $trends = $this->getEvaluationTrends($adminId, $startDate, $endDate);

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'criteria_stats' => $criteriaStats,
                'trends' => $trends
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '통계 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 평가 트렌드 데이터 생성
     */
    private function getEvaluationTrends($adminId, $startDate = null, $endDate = null)
    {
        $query = SiteSupportEvaluation::where('evaluated_admin_id', $adminId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            // 기본적으로 최근 12개월
            $query->where('created_at', '>=', now()->subMonths(12));
        }

        $trends = $query->selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                COUNT(*) as total_evaluations,
                AVG(rating) as average_rating
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return $trends->map(function ($trend) {
            return [
                'month' => $trend->month,
                'total_evaluations' => $trend->total_evaluations,
                'average_rating' => round($trend->average_rating, 2)
            ];
        });
    }

    /**
     * 관리자 순위 조회
     */
    private function getAdminRanking($adminId, $startDate = null, $endDate = null)
    {
        $query = SiteSupportEvaluation::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $allRankings = $query->selectRaw('
                evaluated_admin_id,
                COUNT(*) as total_evaluations,
                AVG(rating) as average_rating,
                SUM(rating) as total_score
            ')
            ->groupBy('evaluated_admin_id')
            ->orderByDesc('average_rating')
            ->orderByDesc('total_evaluations')
            ->get();

        $currentAdminRank = null;
        foreach ($allRankings as $index => $ranking) {
            if ($ranking->evaluated_admin_id == $adminId) {
                $currentAdminRank = $index + 1;
                break;
            }
        }

        return [
            'current_rank' => $currentAdminRank,
            'total_admins' => $allRankings->count(),
            'percentile' => $currentAdminRank ? round((1 - ($currentAdminRank - 1) / $allRankings->count()) * 100, 1) : 0
        ];
    }

    /**
     * 다른 관리자 통계 조회 권한 확인
     */
    private function canViewOtherAdminStats()
    {
        // 여기서는 간단히 관리자면 모든 통계 조회 가능으로 설정
        // 실제로는 더 세밀한 권한 체계를 구현할 수 있음
        return auth()->user()->isAdmin;
    }

    /**
     * 평가 비교 분석
     */
    public function compareAdmins(Request $request)
    {
        $request->validate([
            'admin_ids' => 'required|array|min:2|max:5',
            'admin_ids.*' => 'exists:users,id'
        ]);

        $adminIds = $request->input('admin_ids');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $comparisons = [];

        foreach ($adminIds as $adminId) {
            $admin = User::findOrFail($adminId);
            $stats = SiteSupportEvaluation::getAdminStats($adminId, $startDate, $endDate);
            $criteriaStats = SiteSupportEvaluation::getCriteriaStats($adminId, $startDate, $endDate);

            $comparisons[] = [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email
                ],
                'stats' => $stats,
                'criteria_stats' => $criteriaStats
            ];
        }

        return response()->json([
            'success' => true,
            'comparisons' => $comparisons
        ]);
    }

    /**
     * 평가 요약 리포트 생성
     */
    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $format = $request->input('format', 'json'); // json, csv, pdf

        try {
            // 전체 통계
            $overallStats = $this->getOverallStats($startDate, $endDate);

            // 관리자별 상세 통계
            $adminStats = $this->getAllAdminStats($startDate, $endDate);

            // 기준별 평균 점수
            $criteriaAverages = $this->getCriteriaAverages($startDate, $endDate);

            $reportData = [
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ],
                'overall_stats' => $overallStats,
                'admin_stats' => $adminStats,
                'criteria_averages' => $criteriaAverages,
                'generated_at' => now()->format('Y-m-d H:i:s')
            ];

            if ($format === 'csv') {
                return $this->exportToCsv($reportData);
            }

            return response()->json([
                'success' => true,
                'report' => $reportData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '리포트 생성 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 전체 통계 조회
     */
    private function getOverallStats($startDate = null, $endDate = null)
    {
        $query = SiteSupportEvaluation::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return [
            'total_evaluations' => $query->count(),
            'average_rating' => round($query->avg('rating'), 2),
            'rating_distribution' => $query->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray(),
            'total_admins_evaluated' => $query->distinct('evaluated_admin_id')->count(),
        ];
    }

    /**
     * 모든 관리자 통계 조회
     */
    private function getAllAdminStats($startDate = null, $endDate = null)
    {
        $admins = User::where('isAdmin', true)->get();
        $stats = [];

        foreach ($admins as $admin) {
            $adminStats = SiteSupportEvaluation::getAdminStats($admin->id, $startDate, $endDate);
            if ($adminStats['total_count'] > 0) {
                $stats[] = [
                    'admin' => [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email
                    ],
                    'stats' => $adminStats
                ];
            }
        }

        return $stats;
    }

    /**
     * 기준별 평균 점수 조회
     */
    private function getCriteriaAverages($startDate = null, $endDate = null)
    {
        $query = SiteSupportEvaluation::whereNotNull('criteria_scores');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $evaluations = $query->get();
        $criteriaAverages = [];

        foreach ($evaluations as $evaluation) {
            if ($evaluation->criteria_scores) {
                foreach ($evaluation->criteria_scores as $criterion => $score) {
                    if (!isset($criteriaAverages[$criterion])) {
                        $criteriaAverages[$criterion] = ['total' => 0, 'count' => 0];
                    }
                    $criteriaAverages[$criterion]['total'] += $score;
                    $criteriaAverages[$criterion]['count']++;
                }
            }
        }

        foreach ($criteriaAverages as $criterion => &$data) {
            $data['average'] = round($data['total'] / $data['count'], 2);
        }

        return $criteriaAverages;
    }

    /**
     * CSV 내보내기
     */
    private function exportToCsv($data)
    {
        $filename = 'evaluation_report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // CSV 헤더
            fputcsv($file, ['관리자명', '이메일', '총 평가수', '평균 평점', '총점']);

            // 데이터 행
            foreach ($data['admin_stats'] as $adminStat) {
                fputcsv($file, [
                    $adminStat['admin']['name'],
                    $adminStat['admin']['email'],
                    $adminStat['stats']['total_count'],
                    $adminStat['stats']['average_rating'],
                    $adminStat['stats']['total_score']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}