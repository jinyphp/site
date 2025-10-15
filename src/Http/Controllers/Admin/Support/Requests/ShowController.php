<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 상세 조회 컨트롤러
 */
class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $support = SiteSupport::with([
            'user',
            'assignedTo',
            'replies' => function($query) {
                $query->with('user')->orderBy('created_at', 'asc');
            },
            'activeAssignments.assignee',
            'evaluations.evaluator'
        ])->findOrFail($id);

        return view('jiny-site::admin.support.requests.show', [
            'support' => $support,
        ]);
    }
}