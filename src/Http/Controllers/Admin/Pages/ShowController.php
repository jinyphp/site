<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $page = SitePage::with(['creator', 'updater'])->findOrFail($id);

        return view('jiny-site::admin.pages.show', compact('page'));
    }
}