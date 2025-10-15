<?php

namespace Jiny\Site\Http\Controllers\Admin\Services\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Service Categories 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_service_categories',
            'view' => 'jiny-site::admin.services.categories.create',
            'title' => 'Service Category 추가',
            'subtitle' => '새로운 서비스 카테고리를 추가합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        // 부모 카테고리 목록 조회
        $parentCategories = DB::table($this->config['table'])
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        return view($this->config['view'], [
            'config' => $this->config,
            'parentCategories' => $parentCategories,
        ]);
    }
}