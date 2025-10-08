<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 언어 생성 폼 표시 컨트롤러
 */
class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('jiny-site::admin.languages.create');
    }
}
