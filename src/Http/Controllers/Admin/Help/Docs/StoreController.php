<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Help 문서 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help',
            'title' => 'Help 문서 관리',
            'subtitle' => '도움말 문서를 관리합니다.',
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|exists:site_help_cate,code',
            'order' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['title', 'content', 'category', 'order']);
        $data['enable'] = $request->boolean('enable');
        $data['views'] = 0;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // order가 없으면 마지막 순서로 설정
        if (!isset($data['order'])) {
            $data['order'] = DB::table($this->config['table'])->max('order') + 1;
        }

        DB::table($this->config['table'])->insert($data);

        return redirect()->route('admin.cms.help.docs.index')
            ->with('success', 'Help 문서가 성공적으로 생성되었습니다.');
    }
}