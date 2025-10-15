<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Products 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_products',
            'redirect_route' => 'admin.site.products.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $product = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Product를 찾을 수 없습니다.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:site_product_categories,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:500',
            'images' => 'nullable|string',
            'features' => 'nullable|string',
            'specifications' => 'nullable|string',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'enable' => 'boolean',
            'featured' => 'boolean',
            'enable_purchase' => 'boolean',
            'enable_cart' => 'boolean',
            'enable_quote' => 'boolean',
            'enable_contact' => 'boolean',
            'enable_social_share' => 'boolean',
        ]);

        // slug 업데이트 (제목이 변경된 경우)
        if ($validated['title'] !== $product->title) {
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
            ->with('success', 'Product가 성공적으로 업데이트되었습니다.');
    }
}