<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Contact 타입 관리 컨트롤러
 */
class TypeController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_contact_type',
            'view' => 'jiny-site::admin.contact.type',
            'title' => 'Contact 타입 관리',
            'subtitle' => '문의 타입을 관리합니다.',
            'per_page' => 15,
        ];
    }

    /**
     * 타입 목록 조회
     */
    public function index(Request $request)
    {
        $query = DB::table($this->config['table']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $types = $query->orderBy('pos', 'asc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = [
            'total' => DB::table($this->config['table'])->count(),
            'enabled' => DB::table($this->config['table'])->where('enable', true)->count(),
            'disabled' => DB::table($this->config['table'])->where('enable', false)->count(),
        ];

        return view($this->config['view'], [
            'types' => $types,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    /**
     * 타입 생성 폼
     */
    public function create()
    {
        return view('jiny-site::admin.contact.type-form', [
            'config' => $this->config,
            'mode' => 'create',
        ]);
    }

    /**
     * 타입 저장
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_contact_type,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['code', 'title', 'description', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // pos가 없으면 마지막 순서로 설정
        if (!isset($data['pos'])) {
            $data['pos'] = DB::table($this->config['table'])->max('pos') + 1;
        }

        DB::table($this->config['table'])->insert($data);

        return redirect()->route('admin.cms.contact.types.index')
            ->with('success', 'Contact 타입이 성공적으로 생성되었습니다.');
    }

    /**
     * 타입 수정 폼
     */
    public function edit($id)
    {
        $type = DB::table($this->config['table'])
            ->where('id', $id)
            ->first();

        if (!$type) {
            return redirect()->route('admin.cms.contact.types.index')
                ->with('error', '타입을 찾을 수 없습니다.');
        }

        return view('jiny-site::admin.contact.type-form', [
            'type' => $type,
            'config' => $this->config,
            'mode' => 'edit',
        ]);
    }

    /**
     * 타입 업데이트
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_contact_type,code,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['code', 'title', 'description', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);

        return redirect()->route('admin.cms.contact.types.index')
            ->with('success', 'Contact 타입이 성공적으로 수정되었습니다.');
    }

    /**
     * 타입 삭제
     */
    public function destroy($id)
    {
        // 해당 타입을 사용하는 contact가 있는지 확인
        $contactCount = DB::table('site_contact')
            ->where('type', function($query) use ($id) {
                $query->select('code')
                    ->from('site_contact_type')
                    ->where('id', $id);
            })
            ->count();

        if ($contactCount > 0) {
            return redirect()->route('admin.cms.contact.types.index')
                ->with('error', '이 타입을 사용하는 문의가 있어 삭제할 수 없습니다.');
        }

        DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.cms.contact.types.index')
            ->with('success', 'Contact 타입이 성공적으로 삭제되었습니다.');
    }

    /**
     * 타입 순서 변경
     */
    public function updateOrder(Request $request)
    {
        $items = $request->get('items', []);

        foreach ($items as $index => $id) {
            DB::table($this->config['table'])
                ->where('id', $id)
                ->update(['pos' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}