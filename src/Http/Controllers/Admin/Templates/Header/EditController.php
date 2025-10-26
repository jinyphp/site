<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;
use Jiny\Site\Models\SiteMenu;

class EditController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    public function __invoke(Request $request, $id)
    {
        $header = $this->headerService->getHeaderById((int) $id);

        if (!$header) {
            abort(404, 'Header not found');
        }

        // 메뉴 목록 가져오기
        $menus = SiteMenu::where('enable', true)
            ->orderBy('menu_code')
            ->get(['menu_code', 'description']);

        return view('jiny-site::admin.templates.header.edit', compact('header', 'menus'));
    }
}