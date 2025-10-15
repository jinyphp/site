<?php

namespace Jiny\Site\Http\Controllers\Admin\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'event_date' => 'required|date',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'enable' => 'boolean'
        ]);

        $history = DB::table('site_about_history')->find($id);

        if (!$history) {
            return redirect()->route('admin.cms.about.history.index')
                ->with('error', '연혁 정보를 찾을 수 없습니다.');
        }

        $data = [
            'event_date' => $request->event_date,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'sort_order' => $request->sort_order ?? 0,
            'enable' => $request->has('enable'),
            'updated_at' => now()
        ];

        DB::table('site_about_history')->where('id', $id)->update($data);

        return redirect()->route('admin.cms.about.history.index')
            ->with('success', '회사 연혁이 성공적으로 수정되었습니다.');
    }
}