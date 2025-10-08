<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * 사이트 서비스
 */
class SiteService
{
    /**
     * 사이트 설정 조회
     *
     * @return array
     */
    public function getSettings()
    {
        return config('site');
    }

    /**
     * 사이트 정보 조회
     *
     * @return object|null
     */
    public function getInfo()
    {
        return DB::table('site_env')->first();
    }

    /**
     * 사이트 정보 업데이트
     *
     * @param array $data
     * @return bool
     */
    public function updateInfo(array $data)
    {
        return DB::table('site_env')
            ->where('id', 1)
            ->update($data);
    }
}
