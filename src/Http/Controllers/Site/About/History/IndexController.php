<?php

namespace Jiny\Site\Http\Controllers\Site\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // 활성화된 연혁만 가져오기, 정렬 순서와 날짜 순으로 정렬
            $histories = DB::table('site_about_history')
                ->where('enable', true)
                ->whereNotNull('event_date')
                ->whereNotNull('title')
                ->orderBy('sort_order', 'asc')
                ->orderBy('event_date', 'desc')
                ->get();

            // 연도별로 그룹화 (선택적)
            $historiesByYear = $histories->filter(function($item) {
                return $item->event_date && strtotime($item->event_date);
            })->groupBy(function($item) {
                return date('Y', strtotime($item->event_date));
            });

            return view('jiny-site::www.about.history.index', compact('histories', 'historiesByYear'));

        } catch (\Exception $e) {
            // 오류 발생 시 빈 컬렉션으로 처리
            $histories = collect();
            $historiesByYear = collect();

            return view('jiny-site::www.about.history.index', compact('histories', 'historiesByYear'));
        }
    }
}