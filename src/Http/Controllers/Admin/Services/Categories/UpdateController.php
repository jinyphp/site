<?php

namespace Jiny\Site\Http\Controllers\Admin\Services\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Service Categories 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_service_categories',
            'redirect_route' => 'admin.site.services.categories.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $category = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$category) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Service Category를 찾을 수 없습니다.');
        }

        $validated = $request->validate([
            'code' => 'required|max:100|unique:site_service_categories,code,' . $id,
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

        // slug 업데이트 (제목이 변경된 경우)
        if ($validated['title'] !== $category->title) {
            $validated['slug'] = Str::slug($validated['title']);

            // 중복 slug 처리 (자기 자신 제외)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (DB::table($this->config['table'])
                    ->where('slug', $validated['slug'])
                    ->where('id', '!=', $id)
                    ->whereNull('deleted_at')
                    ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // 순환 참조 방지 (자기 자신을 부모로 설정 불가)
        if (isset($validated['parent_id']) && $validated['parent_id'] == $id) {
            return redirect()
                ->back()
                ->withErrors(['parent_id' => '자기 자신을 부모 카테고리로 설정할 수 없습니다.'])
                ->withInput();
        }

        $validated['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Service Category가 성공적으로 업데이트되었습니다.');
    }
}