<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * Help 카테고리 서비스 클래스 (SAC Pattern)
 */
class CategoryService
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 카테고리 목록 조회
     */
    public function getCategories(Request $request)
    {
        $query = DB::table($this->config['table']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('pos', 'asc')
            ->paginate($this->config['per_page'])
            ->withQueryString();
    }

    /**
     * 카테고리 통계 조회
     */
    public function getStats()
    {
        return [
            'total' => DB::table($this->config['table'])->count(),
            'enabled' => DB::table($this->config['table'])->where('enable', true)->count(),
            'disabled' => DB::table($this->config['table'])->where('enable', false)->count(),
        ];
    }

    /**
     * 카테고리 상세 조회
     */
    public function getCategory($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->first();
    }

    /**
     * 카테고리 저장
     */
    public function store(Request $request)
    {
        $validator = $this->validateCategory($request);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $data = $this->prepareData($request);

        // pos가 없으면 마지막 순서로 설정
        if (!isset($data['pos'])) {
            $data['pos'] = DB::table($this->config['table'])->max('pos') + 1;
        }

        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table($this->config['table'])->insertGetId($data);

        return [
            'success' => true,
            'id' => $id,
            'message' => '카테고리가 성공적으로 생성되었습니다.'
        ];
    }

    /**
     * 카테고리 업데이트
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateCategory($request, $id);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $data = $this->prepareData($request);
        $data['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);

        return [
            'success' => true,
            'message' => '카테고리가 성공적으로 수정되었습니다.'
        ];
    }

    /**
     * 카테고리 삭제
     */
    public function delete($id)
    {
        // 해당 카테고리를 사용하는 help가 있는지 확인
        $helpCount = DB::table('site_help')
            ->where('category', function($query) use ($id) {
                $query->select('code')
                    ->from('site_help_cate')
                    ->where('id', $id);
            })
            ->count();

        if ($helpCount > 0) {
            return [
                'success' => false,
                'message' => '이 카테고리를 사용하는 도움말이 있어 삭제할 수 없습니다.'
            ];
        }

        DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();

        return [
            'success' => true,
            'message' => '카테고리가 성공적으로 삭제되었습니다.'
        ];
    }

    /**
     * 카테고리 순서 변경
     */
    public function updateOrder(array $items)
    {
        foreach ($items as $index => $id) {
            DB::table($this->config['table'])
                ->where('id', $id)
                ->update(['pos' => $index + 1]);
        }

        return [
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ];
    }

    /**
     * 카테고리 유효성 검사
     */
    protected function validateCategory(Request $request, $id = null)
    {
        $rules = [
            'code' => 'required|string|max:50|unique:site_help_cate,code',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ];

        if ($id) {
            $rules['code'] = 'required|string|max:50|unique:site_help_cate,code,' . $id;
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * 저장용 데이터 준비
     */
    protected function prepareData(Request $request)
    {
        $data = $request->only(['code', 'title', 'content', 'icon', 'image', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['manager'] = auth()->user()->email ?? 'system';
        $data['like'] = 0;

        return $data;
    }
}