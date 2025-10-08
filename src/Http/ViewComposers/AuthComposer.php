<?php

namespace Jiny\Site\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\UnencryptedToken;

/**
 * JWT와 세션 인증을 통합적으로 처리하는 뷰 컴포저
 */
class AuthComposer
{
    public function compose(View $view)
    {
        $user = $this->getAuthenticatedUser();

        // 디버그 로그
        \Log::info('AuthComposer Debug', [
            'view_name' => $view->getName(),
            'user' => $user ? [
                'id' => $user->id ?? null,
                'email' => $user->email ?? null,
                'name' => $user->name ?? null,
            ] : null,
            'session_auth' => Auth::check(),
            'session_user' => Auth::user() ? [
                'id' => Auth::user()->id ?? null,
                'email' => Auth::user()->email ?? null,
            ] : null,
        ]);

        // 뷰에 통합 인증 정보 전달
        $view->with([
            'authUser' => $user,
            'isAuthenticated' => $user !== null,
            'authUserId' => $user ? $user->id ?? null : null,
            'authUserEmail' => $user ? $user->email ?? null : null,
            'authUserName' => $user ? ($user->name ?? $user->email) : null,
        ]);
    }

    /**
     * JWT와 세션 방식을 통합하여 인증된 사용자 정보 반환
     */
    private function getAuthenticatedUser()
    {
        // 1. 먼저 세션 기반 Auth 확인
        if (Auth::check()) {
            return Auth::user();
        }

        // 2. JWT 토큰 확인
        $request = request();
        $jwtUser = $this->setupJwtAuth($request);

        if ($jwtUser) {
            return $jwtUser;
        }

        return null;
    }

    /**
     * JWT 인증 설정 (BoardPermissions 트레이트와 동일한 로직)
     */
    private function setupJwtAuth($request)
    {
        try {
            // 쿠키에서 액세스 토큰 가져오기
            $accessToken = $request->cookie('access_token');

            if (!$accessToken) {
                return null;
            }

            // JWT 토큰 파싱 및 검증
            $parser = new Parser(new JoseEncoder());
            $token = $parser->parse($accessToken);

            if (!$token instanceof UnencryptedToken) {
                return null;
            }

            // 토큰 검증
            $validator = new Validator();
            $constraints = [
                new IssuedBy(config('app.url', 'http://localhost')),
                new PermittedFor(config('app.url', 'http://localhost')),
            ];

            if (!$validator->validate($token, ...$constraints)) {
                return null;
            }

            // 토큰에서 사용자 정보 추출
            $claims = $token->claims();
            $userId = $claims->get('sub');
            $userEmail = $claims->get('email');
            $userName = $claims->get('name');

            // 사용자 객체 생성 (stdClass로 통일)
            $user = new \stdClass();
            $user->id = $userId;
            $user->email = $userEmail;
            $user->name = $userName;

            return $user;

        } catch (\Exception $e) {
            \Log::warning('JWT auth failed in AuthComposer', [
                'error' => $e->getMessage(),
                'token' => substr($accessToken ?? '', 0, 20) . '...'
            ]);
            return null;
        }
    }
}