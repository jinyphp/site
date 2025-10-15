<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 상세 조회 컨트롤러
 *
 * 진입 경로:
 * Route::get('/contact/{contactNumber}') → ShowController::__invoke()
 */
class ShowController extends BaseController
{
    /**
     * 상담 요청 상세 조회 (메인 진입점)
     *
     * @param Request $request
     * @param string $contactNumber
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $contactNumber)
    {
        $contact = SiteContact::with(['contactType', 'user', 'assignedUser', 'publicComments.user'])
                              ->where('contact_number', $contactNumber)
                              ->firstOrFail();

        // 본인이 작성했거나 공개 설정된 상담만 조회 가능
        if (!$this->canViewContact($contact)) {
            abort(403, '접근 권한이 없습니다.');
        }

        return view('jiny-site::www.contact.show', compact('contact'));
    }
}