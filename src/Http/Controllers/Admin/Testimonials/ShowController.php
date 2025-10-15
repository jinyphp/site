<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_testimonials',
            'view' => 'jiny-site::admin.testimonials.show',
            'title' => 'Testimonial 상세보기',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $testimonial = DB::table($this->config['table'])
            ->leftJoin('users', 'site_testimonials.user_id', '=', 'users.id')
            ->leftJoin('site_products', function($join) {
                $join->on('site_testimonials.item_id', '=', 'site_products.id')
                     ->where('site_testimonials.type', '=', 'product');
            })
            ->leftJoin('site_services', function($join) {
                $join->on('site_testimonials.item_id', '=', 'site_services.id')
                     ->where('site_testimonials.type', '=', 'service');
            })
            ->select(
                'site_testimonials.*',
                'users.name as user_name',
                'users.email as user_email',
                'site_products.title as product_title',
                'site_products.slug as product_slug',
                'site_services.title as service_title',
                'site_services.slug as service_slug'
            )
            ->where('site_testimonials.id', $id)
            ->whereNull('site_testimonials.deleted_at')
            ->first();

        if (!$testimonial) {
            return redirect()
                ->route('admin.site.testimonials.index')
                ->with('error', 'Testimonial을 찾을 수 없습니다.');
        }

        // Get likes for this testimonial
        $likes = DB::table('site_testimonial_likes')
            ->leftJoin('users', 'site_testimonial_likes.user_id', '=', 'users.id')
            ->select(
                'site_testimonial_likes.*',
                'users.name as user_name'
            )
            ->where('testimonial_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view($this->config['view'], [
            'testimonial' => $testimonial,
            'likes' => $likes,
            'config' => $this->config,
        ]);
    }
}