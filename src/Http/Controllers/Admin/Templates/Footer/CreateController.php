<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('jiny-site::admin.templates.footer.create');
    }
}