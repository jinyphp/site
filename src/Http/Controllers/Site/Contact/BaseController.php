<?php

namespace Jiny\Site\Http\Controllers\Site\Contact;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteContact;
use Jiny\Site\Models\SiteContactType;

/**
 * 사이트 상담 요청 기본 컨트롤러
 *
 * 모든 상담 요청 컨트롤러의 공통 기능을 제공합니다.
 */
class BaseController extends Controller
{
    /**
     * 활성화된 상담 유형 목록 조회
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getContactTypes()
    {
        return SiteContactType::where('enable', true)->orderBy('sort_order')->get();
    }

    /**
     * 상담 조회 권한 확인
     *
     * @param SiteContact $contact
     * @return bool
     */
    protected function canViewContact(SiteContact $contact): bool
    {
        // 공개 설정된 상담
        if ($contact->is_public) {
            return true;
        }

        // 본인이 작성한 상담
        if (Auth::check() && $contact->user_id === Auth::id()) {
            return true;
        }

        // 이메일이 일치하는 경우 (비회원)
        if (!Auth::check() && session('guest_email') === $contact->email) {
            return true;
        }

        return false;
    }

    /**
     * 상담 수정 권한 확인
     *
     * @param SiteContact $contact
     * @return bool
     */
    protected function canEditContact(SiteContact $contact): bool
    {
        // 이미 처리된 상담은 수정 불가
        if (in_array($contact->status, ['completed', 'cancelled'])) {
            return false;
        }

        // 본인이 작성한 상담만 수정 가능
        if (Auth::check() && $contact->user_id === Auth::id()) {
            return true;
        }

        return false;
    }

    /**
     * 상담 취소 권한 확인
     *
     * @param SiteContact $contact
     * @return bool
     */
    protected function canCancelContact(SiteContact $contact): bool
    {
        // 이미 처리된 상담은 취소 불가
        if (in_array($contact->status, ['completed', 'cancelled'])) {
            return false;
        }

        // 본인이 작성한 상담만 취소 가능
        if (Auth::check() && $contact->user_id === Auth::id()) {
            return true;
        }

        return false;
    }

    /**
     * 공통 검증 규칙
     *
     * @return array
     */
    protected function getValidationRules(): array
    {
        return [
            'contact_type_id' => 'required|exists:site_contact_types,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'is_public' => 'boolean'
        ];
    }
}