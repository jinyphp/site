<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class UpdateOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:site_pages,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($validated['items'] as $item) {
            SitePage::where('id', $item['id'])->update([
                'sort_order' => $item['sort_order']
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '페이지 순서가 업데이트되었습니다.'
            ]);
        }

        return back()->with('success', '페이지 순서가 업데이트되었습니다.');
    }
}