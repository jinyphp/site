<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Products 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_products',
            'redirect_route' => 'admin.site.products.index',
        ];
    }

    public function __invoke(Request $request)
    {
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

        // slug 생성
        $validated['slug'] = Str::slug($validated['title']);

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

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table($this->config['table'])->insertGetId($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Product가 성공적으로 생성되었습니다.');
    }
}