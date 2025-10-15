<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/contacts/') → IndexController::__invoke()
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_contact',
            'view' => 'jiny-site::admin.contact.contacts.index',
            'title' => 'Contact 관리',
            'subtitle' => '고객 문의를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $contacts = $query->orderBy("site_contact.{$sortBy}", $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $types = $this->getTypes();

        return view($this->config['view'], [
            'contacts' => $contacts,
            'stats' => $stats,
            'types' => $types,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_contact_type', 'site_contact.type', '=', 'site_contact_type.code')
            ->select(
                'site_contact.*',
                'site_contact_type.title as type_title'
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_contact.name', 'like', "%{$search}%")
                  ->orWhere('site_contact.email', 'like', "%{$search}%")
                  ->orWhere('site_contact.subject', 'like', "%{$search}%")
                  ->orWhere('site_contact.message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->get('type') !== 'all') {
            $query->where('site_contact.type', $request->get('type'));
        }

        if ($request->filled('status') && $request->get('status') !== 'all') {
            $query->where('site_contact.status', $request->get('status'));
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'pending' => DB::table($table)->where('status', 'pending')->count(),
            'replied' => DB::table($table)->where('status', 'replied')->count(),
            'closed' => DB::table($table)->where('status', 'closed')->count(),
            'unread' => DB::table($table)->whereNull('read_at')->count(),
        ];
    }

    protected function getTypes()
    {
        return DB::table('site_contact_type')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();
    }
}