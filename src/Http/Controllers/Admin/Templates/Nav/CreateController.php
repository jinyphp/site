<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('jiny-site::admin.templates.nav.create');
    }
}
