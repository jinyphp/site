<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * 페이지 서비스
 */
class PageService
{
    /**
     * 슬러그로 페이지 조회
     *
     * @param string $slug
     * @return array|null
     */
    public function getPageBySlug($slug)
    {
        $page = DB::table('jiny_route')
            ->where('uri', $slug)
            ->where('enabled', true)
            ->first();

        return $page ? (array) $page : null;
    }

    /**
     * 모든 페이지 조회
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllPages()
    {
        return DB::table('jiny_route')
            ->where('enabled', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * 페이지 생성
     *
     * @param array $data
     * @return int
     */
    public function createPage(array $data)
    {
        return DB::table('jiny_route')->insertGetId($data);
    }

    /**
     * 페이지 업데이트
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePage($id, array $data)
    {
        return DB::table('jiny_route')
            ->where('id', $id)
            ->update($data);
    }

    /**
     * 페이지 삭제
     *
     * @param int $id
     * @return bool
     */
    public function deletePage($id)
    {
        return DB::table('jiny_route')
            ->where('id', $id)
            ->delete();
    }
}
