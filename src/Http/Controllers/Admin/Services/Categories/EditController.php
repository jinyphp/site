<?php

namespace Jiny\Site\Http\Controllers\Admin\Services\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Service Categories 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_service_categories',
            'view' => 'jiny-site::admin.services.categories.edit',
            'title' => 'Service Category 수정',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $category = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$category) {
            return redirect()
                ->route('admin.site.services.categories.index')
                ->with('error', 'Service Category를 찾을 수 없습니다.');
        }

        // 부모 카테고리 목록 조회 (자기 자신과 하위 카테고리 제외)
        $parentCategories = DB::table($this->config['table'])
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->where('id', '!=', $id)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        return view($this->config['view'], [
            'category' => $category,
            'parentCategories' => $parentCategories,
            'config' => $this->config,
        ]);
    }
}