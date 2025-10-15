<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 수정 컨트롤러
 *
 * 진입 경로:
 * Route::put('/contact/{contactNumber}') → UpdateController::__invoke()
 */
class UpdateController extends BaseController
{
    /**
     * 상담 요청 수정 (메인 진입점)
     *
     * @param Request $request
     * @param string $contactNumber
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $contactNumber)
    {
        $contact = SiteContact::where('contact_number', $contactNumber)->firstOrFail();

        if (!$this->canEditContact($contact)) {
            abort(403, '수정 권한이 없습니다.');
        }

        $validated = $request->validate($this->getValidationRules());

        $contact->update($validated);

        session()->flash('success', '상담 요청이 성공적으로 수정되었습니다.');

        return redirect()->route('contact.show', $contact->contact_number);
    }
}