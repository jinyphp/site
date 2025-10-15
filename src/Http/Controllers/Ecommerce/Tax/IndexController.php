<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Tax;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 국가별 세율 관리 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_countries',
            'view' => 'jiny-site::ecommerce.tax.index',
            'title' => '세율 관리',
            'subtitle' => '국가별 세율 정보를 관리합니다.',
            'per_page' => 20,
        ];
    }

    public function __invoke(Request $request)
    {
        try {
            // Check if table exists
            if (!$this->checkTableExists()) {
                $emptyPaginator = new LengthAwarePaginator(
                    collect(),
                    0,
                    $this->config['per_page'],
                    1,
                    ['path' => request()->url(), 'pageName' => 'page']
                );

                return view($this->config['view'], [
                    'countries' => $emptyPaginator,
                    'stats' => $this->getDefaultStats(),
                    'taxTypes' => collect(),
                    'config' => $this->config,
                    'tableNotExist' => true,
                ]);
            }

            $query = $this->buildQuery();
            $query = $this->applyFilters($query, $request);

            $countries = $query->orderBy('site_countries.name', 'asc')
                ->paginate($this->config['per_page'])
                ->withQueryString();

            $stats = $this->getStatistics();
            $taxTypes = $this->getTaxTypes();

            return view($this->config['view'], [
                'countries' => $countries,
                'stats' => $stats,
                'taxTypes' => $taxTypes,
                'config' => $this->config,
            ]);
        } catch (\Exception $e) {
            $emptyPaginator = new LengthAwarePaginator(
                collect(),
                0,
                $this->config['per_page'],
                1,
                ['path' => request()->url(), 'pageName' => 'page']
            );

            return view($this->config['view'], [
                'countries' => $emptyPaginator,
                'stats' => $this->getDefaultStats(),
                'taxTypes' => collect(),
                'config' => $this->config,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_currencies', 'site_countries.currency_code', '=', 'site_currencies.code')
            ->select(
                'site_countries.*',
                'site_currencies.name as currency_name',
                'site_currencies.symbol as currency_symbol'
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_countries.name', 'like', "%{$search}%")
                  ->orWhere('site_countries.name_ko', 'like', "%{$search}%")
                  ->orWhere('site_countries.code', 'like', "%{$search}%")
                  ->orWhere('site_countries.tax_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tax_name') && $request->get('tax_name') !== 'all') {
            $query->where('site_countries.tax_name', $request->get('tax_name'));
        }

        if ($request->filled('continent') && $request->get('continent') !== 'all') {
            $query->where('site_countries.continent', $request->get('continent'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_countries.enable', $request->get('enable') === '1');
        }

        if ($request->filled('tax_rate_min')) {
            $query->where('site_countries.tax_rate', '>=', $request->get('tax_rate_min') / 100);
        }

        if ($request->filled('tax_rate_max')) {
            $query->where('site_countries.tax_rate', '<=', $request->get('tax_rate_max') / 100);
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        $stats = [
            'total_countries' => DB::table($table)->count(),
            'active_countries' => DB::table($table)->where('enable', true)->count(),
            'with_tax' => DB::table($table)->where('tax_rate', '>', 0)->count(),
            'no_tax' => DB::table($table)->where('tax_rate', '=', 0)->count(),
            'avg_tax_rate' => DB::table($table)->where('tax_rate', '>', 0)->avg('tax_rate'),
            'max_tax_rate' => DB::table($table)->max('tax_rate'),
            'min_tax_rate' => DB::table($table)->where('tax_rate', '>', 0)->min('tax_rate'),
        ];

        // Convert decimal to percentage for display
        $stats['avg_tax_rate'] = $stats['avg_tax_rate'] ? round($stats['avg_tax_rate'] * 100, 2) : 0;
        $stats['max_tax_rate'] = $stats['max_tax_rate'] ? round($stats['max_tax_rate'] * 100, 2) : 0;
        $stats['min_tax_rate'] = $stats['min_tax_rate'] ? round($stats['min_tax_rate'] * 100, 2) : 0;

        // Tax type breakdown
        $taxTypeStats = DB::table($table)
            ->select('tax_name', DB::raw('COUNT(*) as count'), DB::raw('AVG(tax_rate) as avg_rate'))
            ->whereNotNull('tax_name')
            ->where('tax_rate', '>', 0)
            ->groupBy('tax_name')
            ->get();

        $stats['tax_types'] = $taxTypeStats->map(function ($item) {
            return [
                'name' => $item->tax_name,
                'count' => $item->count,
                'avg_rate' => round($item->avg_rate * 100, 2)
            ];
        });

        // Continent breakdown
        $continentStats = DB::table($table)
            ->select('continent', DB::raw('COUNT(*) as count'), DB::raw('AVG(tax_rate) as avg_rate'))
            ->whereNotNull('continent')
            ->groupBy('continent')
            ->get();

        $stats['continents'] = $continentStats->map(function ($item) {
            return [
                'name' => $item->continent,
                'count' => $item->count,
                'avg_rate' => round($item->avg_rate * 100, 2)
            ];
        });

        return $stats;
    }

    protected function getTaxTypes()
    {
        return DB::table($this->config['table'])
            ->select('tax_name')
            ->distinct()
            ->whereNotNull('tax_name')
            ->where('tax_name', '!=', '')
            ->orderBy('tax_name')
            ->pluck('tax_name');
    }

    protected function getContinents()
    {
        return DB::table($this->config['table'])
            ->select('continent')
            ->distinct()
            ->whereNotNull('continent')
            ->where('continent', '!=', '')
            ->orderBy('continent')
            ->pluck('continent');
    }

    /**
     * 테이블 존재 여부 확인
     */
    protected function checkTableExists()
    {
        try {
            return DB::connection()->getSchemaBuilder()->hasTable('site_countries');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 기본 통계 반환 (테이블이 없을 때)
     */
    protected function getDefaultStats()
    {
        return [
            'total_countries' => 0,
            'active_countries' => 0,
            'with_tax' => 0,
            'no_tax' => 0,
            'avg_tax_rate' => 0,
            'max_tax_rate' => 0,
            'min_tax_rate' => 0,
            'tax_types' => collect(),
            'continents' => collect(),
        ];
    }

    /**
     * 세율 업데이트 (AJAX)
     */
    public function updateTaxRate(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'tax_rate' => 'required|numeric|min:0|max:100',
                'tax_name' => 'required|string|max:50',
                'tax_description' => 'nullable|string|max:500',
            ]);

            // Convert percentage to decimal
            $taxRateDecimal = $validated['tax_rate'] / 100;

            $updated = DB::table('site_countries')
                ->where('id', $id)
                ->update([
                    'tax_rate' => $taxRateDecimal,
                    'tax_name' => $validated['tax_name'],
                    'tax_description' => $validated['tax_description'],
                    'updated_at' => now(),
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => '세율이 성공적으로 업데이트되었습니다.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '국가를 찾을 수 없습니다.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '세율 업데이트 실패: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 일괄 세율 업데이트 (AJAX)
     */
    public function bulkUpdateTaxRate(Request $request)
    {
        try {
            $validated = $request->validate([
                'countries' => 'required|array',
                'countries.*' => 'integer|exists:site_countries,id',
                'tax_rate' => 'required|numeric|min:0|max:100',
                'tax_name' => 'required|string|max:50',
                'tax_description' => 'nullable|string|max:500',
            ]);

            // Convert percentage to decimal
            $taxRateDecimal = $validated['tax_rate'] / 100;

            $updated = DB::table('site_countries')
                ->whereIn('id', $validated['countries'])
                ->update([
                    'tax_rate' => $taxRateDecimal,
                    'tax_name' => $validated['tax_name'],
                    'tax_description' => $validated['tax_description'],
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => "{$updated}개 국가의 세율이 성공적으로 업데이트되었습니다.",
                'updated_count' => $updated,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '일괄 세율 업데이트 실패: ' . $e->getMessage(),
            ], 500);
        }
    }
}