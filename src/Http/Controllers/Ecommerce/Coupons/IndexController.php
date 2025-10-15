<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Coupons;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Coupon::query();

        // 검색 기능
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 상태 필터
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 타입 필터
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // 정렬
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $coupons = $query->paginate(15);

        // 통계 데이터
        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('status', 'active')->count(),
            'inactive' => Coupon::where('status', 'inactive')->count(),
            'expired' => Coupon::where('status', 'expired')->count(),
        ];

        return view('jiny-site::ecommerce.coupons.index', compact('coupons', 'stats'));
    }
}