<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class BulkActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string|in:delete,publish,draft,private,featured,unfeatured',
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:site_pages,id'
        ]);

        $pages = SitePage::whereIn('id', $validated['ids']);
        $count = $pages->count();

        switch ($validated['action']) {
            case 'delete':
                $pages->delete();
                $message = "{$count}개의 페이지가 삭제되었습니다.";
                break;

            case 'publish':
                $pages->update([
                    'status' => SitePage::STATUS_PUBLISHED,
                    'published_at' => now(),
                ]);
                $message = "{$count}개의 페이지가 발행되었습니다.";
                break;

            case 'draft':
                $pages->update(['status' => SitePage::STATUS_DRAFT]);
                $message = "{$count}개의 페이지가 임시저장으로 변경되었습니다.";
                break;

            case 'private':
                $pages->update(['status' => SitePage::STATUS_PRIVATE]);
                $message = "{$count}개의 페이지가 비공개로 변경되었습니다.";
                break;

            case 'featured':
                $pages->update(['is_featured' => true]);
                $message = "{$count}개의 페이지가 추천 페이지로 설정되었습니다.";
                break;

            case 'unfeatured':
                $pages->update(['is_featured' => false]);
                $message = "{$count}개의 페이지가 추천 페이지에서 해제되었습니다.";
                break;

            default:
                return back()->with('error', '잘못된 작업입니다.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}