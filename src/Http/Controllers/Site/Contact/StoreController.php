<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 저장 컨트롤러
 *
 * 진입 경로:
 * Route::post('/contact') → StoreController::__invoke()
 */
class StoreController extends BaseController
{
    /**
     * 상담 요청 저장 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());

        $contact = SiteContact::create($validated);

        session()->flash('success', '상담 요청이 성공적으로 접수되었습니다. 문의번호: ' . $contact->contact_number);

        return redirect()->route('contact.show', $contact->contact_number);
    }
}