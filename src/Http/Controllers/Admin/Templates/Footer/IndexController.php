<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Jiny\Site\Services\FooterService;

class IndexController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke()
    {
        $footers = $this->footerService->getAllFooters();
        $stats = $this->footerService->getFooterStats();

        return view('jiny-site::admin.templates.footer.index', compact('footers', 'stats'));
    }
}