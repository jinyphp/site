<?php

namespace Jiny\Site\Http\Controllers\Admin\Services;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Services 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_services',
            'redirect_route' => 'admin.site.services.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $service = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$service) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Service를 찾을 수 없습니다.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:site_service_categories,id',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'images' => 'nullable|string',
            'features' => 'nullable|string',
            'process' => 'nullable|string',
            'requirements' => 'nullable|string',
            'deliverables' => 'nullable|string',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'enable' => 'boolean',
            'featured' => 'boolean',
        ]);

        // slug 업데이트 (제목이 변경된 경우)
        if ($validated['title'] !== $service->title) {
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

        $validated['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Service가 성공적으로 업데이트되었습니다.');
    }
}