<?php

namespace Jiny\Site\Http\Controllers\Admin\Services\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Service Categories 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_service_categories',
            'redirect_route' => 'admin.site.services.categories.index',
        ];
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|max:100|unique:site_service_categories,code',
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:site_service_categories,id',
            'pos' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'enable' => 'boolean',
        ]);

        // code가 비어있으면 title에서 자동 생성
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['title']);
        }

        // slug 생성
        $validated['slug'] = Str::slug($validated['title']);

        // 중복 code 처리
        $originalCode = $validated['code'];
        $count = 1;
        while (DB::table($this->config['table'])
                ->where('code', $validated['code'])
                ->whereNull('deleted_at')
                ->exists()) {
            $validated['code'] = $originalCode . '-' . $count;
            $count++;
        }

        // 중복 slug 처리
        $originalSlug = $validated['slug'];
        $count = 1;
        while (DB::table($this->config['table'])
                ->where('slug', $validated['slug'])
                ->whereNull('deleted_at')
                ->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        // pos가 설정되지 않았으면 마지막 순서로 설정
        if (!isset($validated['pos'])) {
            $maxPos = DB::table($this->config['table'])
                ->where('parent_id', $validated['parent_id'] ?? null)
                ->whereNull('deleted_at')
                ->max('pos');
            $validated['pos'] = ($maxPos ?? 0) + 1;
        }

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table($this->config['table'])->insertGetId($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Service Category가 성공적으로 생성되었습니다.');
    }
}