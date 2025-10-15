<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 취소 컨트롤러
 *
 * 진입 경로:
 * Route::post('/contact/{contactNumber}/cancel') → CancelController::__invoke()
 */
class CancelController extends BaseController
{
    /**
     * 상담 요청 취소 (메인 진입점)
     *
     * @param Request $request
     * @param string $contactNumber
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $contactNumber)
    {
        $contact = SiteContact::where('contact_number', $contactNumber)->firstOrFail();

        if (!$this->canCancelContact($contact)) {
            abort(403, '취소 권한이 없습니다.');
        }

        $contact->update([
            'status' => 'cancelled',
            'processed_at' => now()
        ]);

        session()->flash('success', '상담 요청이 취소되었습니다.');

        return redirect()->route('contact.show', $contact->contact_number);
    }
}