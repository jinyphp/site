<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_testimonials',
            'view' => 'jiny-site::admin.testimonials.index',
            'title' => 'Testimonials 관리',
            'subtitle' => '고객 후기와 평가를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request, $type = null, $itemId = null)
    {
        $query = $this->buildQuery();

        // Filter by specific product/service if provided
        if ($type && $itemId) {
            $query->where('type', $type)->where('item_id', $itemId);
        }

        $query = $this->applyFilters($query, $request);

        $testimonials = $query->orderBy('featured', 'desc')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics($type, $itemId);

        return view($this->config['view'], [
            'testimonials' => $testimonials,
            'stats' => $stats,
            'config' => $this->config,
            'type' => $type,
            'itemId' => $itemId,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
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
                'site_services.title as service_title'
            )
            ->whereNull('site_testimonials.deleted_at');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_testimonials.headline', 'like', "%{$search}%")
                  ->orWhere('site_testimonials.content', 'like', "%{$search}%")
                  ->orWhere('site_testimonials.name', 'like', "%{$search}%")
                  ->orWhere('site_testimonials.company', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('site_testimonials.type', $request->get('type'));
        }

        if ($request->filled('rating')) {
            $query->where('site_testimonials.rating', $request->get('rating'));
        }

        if ($request->filled('featured')) {
            $query->where('site_testimonials.featured', $request->get('featured') === '1');
        }

        if ($request->filled('verified')) {
            $query->where('site_testimonials.verified', $request->get('verified') === '1');
        }

        if ($request->filled('enable')) {
            $query->where('site_testimonials.enable', $request->get('enable') === '1');
        }

        return $query;
    }

    protected function getStatistics($type = null, $itemId = null)
    {
        $table = $this->config['table'];
        $query = DB::table($table)->whereNull('deleted_at');

        if ($type && $itemId) {
            $query->where('type', $type)->where('item_id', $itemId);
        }

        $base = clone $query;

        return [
            'total' => $base->count(),
            'enabled' => (clone $query)->where('enable', true)->count(),
            'featured' => (clone $query)->where('featured', true)->count(),
            'verified' => (clone $query)->where('verified', true)->count(),
            'five_stars' => (clone $query)->where('rating', 5)->count(),
            'four_stars' => (clone $query)->where('rating', 4)->count(),
            'three_stars' => (clone $query)->where('rating', 3)->count(),
            'two_stars' => (clone $query)->where('rating', 2)->count(),
            'one_star' => (clone $query)->where('rating', 1)->count(),
            'average_rating' => round((clone $query)->avg('rating'), 1),
            'total_likes' => (clone $query)->sum('likes_count'),
        ];
    }
}