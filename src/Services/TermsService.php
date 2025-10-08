<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * 약관 서비스
 */
class TermsService
{
    /**
     * 타입별 약관 조회
     *
     * @param string $type
     * @return array
     */
    public function getTermsByType($type)
    {
        $terms = DB::table('site_terms')
            ->where('type', $type)
            ->where('enabled', true)
            ->orderBy('version', 'desc')
            ->first();

        if (!$terms) {
            return [
                'type' => $type,
                'title' => $this->getDefaultTitle($type),
                'content' => '',
                'version' => '1.0',
            ];
        }

        return (array) $terms;
    }

    /**
     * 기본 제목 조회
     *
     * @param string $type
     * @return string
     */
    protected function getDefaultTitle($type)
    {
        $titles = [
            'use' => '이용약관',
            'privacy' => '개인정보처리방침',
            'marketing' => '마케팅 수신 동의',
        ];

        return $titles[$type] ?? '약관';
    }

    /**
     * 모든 약관 조회
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllTerms()
    {
        return DB::table('site_terms')
            ->orderBy('type')
            ->orderBy('version', 'desc')
            ->get();
    }
}
