<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 번호로 검색 컨트롤러
 *
 * 진입 경로:
 * Route::get('/contact/search') → SearchController::__invoke()
 * Route::post('/contact/search') → SearchController::__invoke()
 */
class SearchController extends BaseController
{
    /**
     * 상담 번호로 검색 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'contact_number' => 'required|string',
                'email' => 'required|email'
            ]);

            $contact = SiteContact::where('contact_number', $request->contact_number)
                                 ->where('email', $request->email)
                                 ->first();

            if ($contact) {
                return redirect()->route('contact.show', $contact->contact_number);
            }

            return back()->withErrors([
                'contact_number' => '해당하는 상담 요청을 찾을 수 없습니다.'
            ])->withInput();
        }

        return view('jiny-site::www.contact.search');
    }
}