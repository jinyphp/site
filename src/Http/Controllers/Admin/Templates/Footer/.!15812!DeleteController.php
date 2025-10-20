<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Jiny\Site\Services\FooterService;

class DeleteController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke($id)
    {
        $footer = $this->footerService->getFooterById((int) $id);

        if (!$footer) {
            abort(404, 'Footer not found');
        }

        $success = $this->footerService->deleteFooter((int) $id);

        if ($success) {
            return redirect()->route('admin.cms.templates.footer.index')
