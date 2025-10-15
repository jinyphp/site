<?php

namespace Jiny\Site\Http\Controllers\Admin\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = DB::table('site_about_history')
            ->orderBy('sort_order', 'asc')
            ->orderBy('event_date', 'desc');

        // 검색 기능
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%");
            });
        }

        // 상태 필터
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('enable', true);
            } elseif ($status === 'inactive') {
                $query->where('enable', false);
            }
        }

        $histories = $query->paginate(15);

        return view('jiny-site::admin.about.history.index', compact('histories'));
    }
}