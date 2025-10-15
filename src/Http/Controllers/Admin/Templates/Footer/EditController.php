<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class EditController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request, $id)
    {
        $footer = $this->footerService->getFooterById((int) $id);

        if (!$footer) {
            abort(404, 'Footer not found');
        }

        return view('jiny-site::admin.templates.footer.edit', compact('footer'));
    }
}
