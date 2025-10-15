<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SiteSupportEvaluation extends Model
{
    use HasFactory;

    protected $table = 'site_support_evaluations';

    protected $fillable = [
        'support_id',
        'evaluator_id',
        'evaluated_admin_id',
        'rating',
        'comment',
        'criteria_scores',
        'is_anonymous',
        'ip_address',
    ];

    protected $casts = [
        'criteria_scores' => 'array',
        'is_anonymous' => 'boolean',
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 지원 요청과의 관계
     */
    public function support()
    {
        return $this->belongsTo(SiteSupport::class, 'support_id');
    }

    /**
     * 평가자와의 관계
     */
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    /**
     * 평가 대상 관리자와의 관계
     */
    public function evaluatedAdmin()
    {
        return $this->belongsTo(User::class, 'evaluated_admin_id');
    }

    /**
     * 특정 관리자의 평가들 조회
     */
    public function scopeForAdmin($query, $adminId)
    {
        return $query->where('evaluated_admin_id', $adminId);
    }

    /**
     * 특정 평점 이상의 평가들 조회
     */
    public function scopeMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * 특정 평점 이하의 평가들 조회
     */
    public function scopeMaxRating($query, $rating)
    {
        return $query->where('rating', '<=', $rating);
    }

    /**
     * 익명 평가들 조회
     */
    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    /**
     * 실명 평가들 조회
     */
    public function scopeNamed($query)
    {
        return $query->where('is_anonymous', false);
    }

    /**
     * 날짜 범위별 평가 조회
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * 평점 라벨
     */
    public function getRatingLabelAttribute()
    {
        $labels = [
            1 => '매우 불만족',
            2 => '불만족',
            3 => '보통',
            4 => '만족',
            5 => '매우 만족',
        ];

        return $labels[$this->rating] ?? '알 수 없음';
    }

    /**
     * 평점별 CSS 클래스
     */
    public function getRatingClassAttribute()
    {
        $classes = [
            1 => 'bg-red-100 text-red-800',
            2 => 'bg-orange-100 text-orange-800',
            3 => 'bg-yellow-100 text-yellow-800',
            4 => 'bg-blue-100 text-blue-800',
            5 => 'bg-green-100 text-green-800',
        ];

        return $classes[$this->rating] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * 별점 HTML 생성
     */
    public function getStarsHtmlAttribute()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $html .= '<i class="far fa-star text-gray-300"></i>';
            }
        }
        return $html;
    }

    /**
     * 세부 평가 기준별 점수 가져오기
     */
    public function getCriteriaScore($criterion)
    {
        return $this->criteria_scores[$criterion] ?? null;
    }

    /**
     * 평가 생성
     */
    public static function createEvaluation($supportId, $evaluatorId, $evaluatedAdminId, $rating, $comment = null, $criteriaScores = null, $isAnonymous = false)
    {
        // 이미 평가가 있는지 확인
        $existing = self::where('support_id', $supportId)
            ->where('evaluator_id', $evaluatorId)
            ->first();

        if ($existing) {
            throw new \Exception('이미 이 지원 요청에 대해 평가를 작성했습니다.');
        }

        return self::create([
            'support_id' => $supportId,
            'evaluator_id' => $evaluatorId,
            'evaluated_admin_id' => $evaluatedAdminId,
            'rating' => $rating,
            'comment' => $comment,
            'criteria_scores' => $criteriaScores,
            'is_anonymous' => $isAnonymous,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * 특정 관리자의 평가 통계 계산
     */
    public static function getAdminStats($adminId, $startDate = null, $endDate = null)
    {
        $query = self::where('evaluated_admin_id', $adminId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $evaluations = $query->get();

        if ($evaluations->isEmpty()) {
            return [
                'total_count' => 0,
                'average_rating' => 0,
                'rating_distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                'total_score' => 0,
            ];
        }

        $totalCount = $evaluations->count();
        $totalScore = $evaluations->sum('rating');
        $averageRating = round($totalScore / $totalCount, 2);

        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($evaluations as $evaluation) {
            $ratingDistribution[$evaluation->rating]++;
        }

        return [
            'total_count' => $totalCount,
            'average_rating' => $averageRating,
            'rating_distribution' => $ratingDistribution,
            'total_score' => $totalScore,
        ];
    }

    /**
     * 전체 관리자들의 평가 랭킹 조회
     */
    public static function getAdminRanking($startDate = null, $endDate = null, $limit = 10)
    {
        $query = self::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->selectRaw('
                evaluated_admin_id,
                COUNT(*) as total_evaluations,
                AVG(rating) as average_rating,
                SUM(rating) as total_score
            ')
            ->with('evaluatedAdmin')
            ->groupBy('evaluated_admin_id')
            ->orderByDesc('average_rating')
            ->orderByDesc('total_evaluations')
            ->limit($limit)
            ->get();
    }

    /**
     * 세부 기준별 평가 통계
     */
    public static function getCriteriaStats($adminId, $startDate = null, $endDate = null)
    {
        $query = self::where('evaluated_admin_id', $adminId)
            ->whereNotNull('criteria_scores');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $evaluations = $query->get();

        if ($evaluations->isEmpty()) {
            return [];
        }

        $criteriaStats = [];
        foreach ($evaluations as $evaluation) {
            if ($evaluation->criteria_scores) {
                foreach ($evaluation->criteria_scores as $criterion => $score) {
                    if (!isset($criteriaStats[$criterion])) {
                        $criteriaStats[$criterion] = [
                            'total' => 0,
                            'count' => 0,
                            'average' => 0,
                        ];
                    }
                    $criteriaStats[$criterion]['total'] += $score;
                    $criteriaStats[$criterion]['count']++;
                }
            }
        }

        // 평균 계산
        foreach ($criteriaStats as $criterion => &$stats) {
            $stats['average'] = round($stats['total'] / $stats['count'], 2);
        }

        return $criteriaStats;
    }
}