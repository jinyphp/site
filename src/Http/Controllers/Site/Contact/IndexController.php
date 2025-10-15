<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 요청 목록 조회 컨트롤러
 *
 * 진입 경로:
 * Route::get('/contact') → IndexController::__invoke()
 */
class IndexController extends BaseController
{
    /**
     * 상담 요청 목록 조회 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('contact.search')
                           ->with('info', '로그인 후 상담 내역을 확인하실 수 있습니다.');
        }

        $query = SiteContact::with(['contactType', 'assignedUser'])
                           ->where('user_id', Auth::id());

        // 상태 필터
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // 상담 유형 필터
        if ($request->has('type') && !empty($request->type)) {
            $query->where('contact_type_id', $request->type);
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(10);
        $contactTypes = $this->getContactTypes();

        return view('jiny-site::www.contact.index', compact('contacts', 'contactTypes'));
    }
}