<?php

namespace Jiny\Site\Http\Controllers\Admin\About\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToggleController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $history = DB::table('site_about_history')->find($id);

        if (!$history) {
            return response()->json(['error' => '연혁 정보를 찾을 수 없습니다.'], 404);
        }

        $newStatus = !$history->enable;

        DB::table('site_about_history')
            ->where('id', $id)
            ->update([
                'enable' => $newStatus,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus ? '활성화되었습니다.' : '비활성화되었습니다.'
        ]);
    }
}