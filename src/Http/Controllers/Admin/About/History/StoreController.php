<?php

namespace Jiny\Site\Http\Controllers\Admin\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'event_date' => 'required|date',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'enable' => 'boolean'
        ]);

        $data = [
            'event_date' => $request->event_date,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'sort_order' => $request->sort_order ?? 0,
            'enable' => $request->has('enable'),
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('site_about_history')->insert($data);

        return redirect()->route('admin.cms.about.history.index')
            ->with('success', '회사 연혁이 성공적으로 등록되었습니다.');
    }
}