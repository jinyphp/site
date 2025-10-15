<?php

namespace Jiny\Site\Http\Controllers\Admin\Services\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Service Categories 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_service_categories',
            'view' => 'jiny-site::admin.services.categories.show',
            'title' => 'Service Category 상세보기',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $category = DB::table($this->config['table'])
            ->leftJoin('site_service_categories as parent', 'site_service_categories.parent_id', '=', 'parent.id')
            ->select(
                'site_service_categories.*',
                'parent.title as parent_title'
            )
            ->where('site_service_categories.id', $id)
            ->whereNull('site_service_categories.deleted_at')
            ->first();

        if (!$category) {
            return redirect()
                ->route('admin.site.services.categories.index')
                ->with('error', 'Service Category를 찾을 수 없습니다.');
        }

        // 하위 카테고리들 조회
        $children = DB::table($this->config['table'])
            ->where('parent_id', $id)
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        // 이 카테고리에 속한 서비스 개수
        $servicesCount = DB::table('site_services')
            ->where('category_id', $id)
            ->whereNull('deleted_at')
            ->count();

        return view($this->config['view'], [
            'category' => $category,
            'children' => $children,
            'servicesCount' => $servicesCount,
            'config' => $this->config,
        ]);
    }
}