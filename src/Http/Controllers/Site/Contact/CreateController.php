<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;

/**
 * 상담 요청 폼 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/about/contact') → CreateController::__invoke()
 * Route::get('/contact/create') → CreateController::__invoke()
 */
class CreateController extends BaseController
{
    /**
     * 상담 요청 폼 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $contactTypes = $this->getContactTypes();

        return view('jiny-site::www.contact.create', compact('contactTypes'));
    }
}