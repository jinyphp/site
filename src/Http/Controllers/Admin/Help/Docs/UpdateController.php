<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Help 문서 업데이트 컨트롤러
 */
class UpdateController extends Controller
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
    public function __invoke(Request $request, $id)
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
        $data['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);

        // 이전 페이지 정보로 리다이렉트
        $returnParams = $request->only(['page', 'search', 'category', 'enable']);
        $returnUrl = route('admin.cms.help.docs.index');

        if (!empty(array_filter($returnParams))) {
            $returnUrl .= '?' . http_build_query($returnParams);
        }

        return redirect($returnUrl)
            ->with('success', 'Help 문서가 성공적으로 수정되었습니다.');
    }
}