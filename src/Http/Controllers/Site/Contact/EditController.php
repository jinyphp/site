<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 수정 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/contact/{contactNumber}/edit') → EditController::__invoke()
 */
class EditController extends BaseController
{
    /**
     * 상담 요청 수정 폼 (메인 진입점)
     *
     * @param Request $request
     * @param string $contactNumber
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $contactNumber)
    {
        $contact = SiteContact::where('contact_number', $contactNumber)->firstOrFail();

        // 본인이 작성했고 아직 처리되지 않은 상담만 수정 가능
        if (!$this->canEditContact($contact)) {
            abort(403, '수정 권한이 없습니다.');
        }

        $contactTypes = $this->getContactTypes();

        return view('jiny-site::www.contact.edit', compact('contact', 'contactTypes'));
    }
}