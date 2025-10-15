<?php

namespace Jiny\Site\Http\Controllers\Admin\Services;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Services 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_services',
            'view' => 'jiny-site::admin.services.show',
            'title' => 'Service 상세보기',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $service = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$service) {
            return redirect()
                ->route('admin.site.services.index')
                ->with('error', 'Service를 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'service' => $service,
            'config' => $this->config,
        ]);
    }
}