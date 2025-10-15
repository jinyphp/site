<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 편집 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_testimonials',
            'view' => 'jiny-site::admin.testimonials.edit',
            'title' => 'Testimonial 편집',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $testimonial = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$testimonial) {
            return redirect()
                ->route('admin.site.testimonials.index')
                ->with('error', 'Testimonial을 찾을 수 없습니다.');
        }

        // Get products and services for selection
        $products = DB::table('site_products')
            ->select('id', 'title')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get();

        $services = DB::table('site_services')
            ->select('id', 'title')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('title')
            ->get();

        return view($this->config['view'], [
            'testimonial' => $testimonial,
            'products' => $products,
            'services' => $services,
            'config' => $this->config,
        ]);
    }
}