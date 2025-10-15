<?php

namespace Jiny\Site\Http\Controllers\Admin\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $history = DB::table('site_about_history')->find($id);

        if (!$history) {
            return redirect()->route('admin.cms.about.history.index')
                ->with('error', '연혁 정보를 찾을 수 없습니다.');
        }

        return view('jiny-site::admin.about.history.edit', compact('history'));
    }
}