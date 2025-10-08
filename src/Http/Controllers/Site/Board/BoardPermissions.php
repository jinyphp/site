<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jiny\Auth\Services\JwtService;

trait BoardPermissions
{
    /**
     * 게시판 정보 조회
     */
    protected function getBoardInfo($code)
    {
        return DB::table('site_board')->where('code', $code)->first();
    }

    /**
     * 조회수 증가
     */
    protected function incrementViews($code, $id)
    {
        $table = "site_board_" . $code;

        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return;
        }

        // 게시글 조회수 증가
        DB::table($table)
            ->where('id', $id)
            ->increment('click');

        // 게시판 총 조회수 증가
        DB::table('site_board')
            ->where('code', $code)
            ->increment('total_views');
    }

    /**
     * 작성자 확인
     */
    protected function isOwner($post)
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        return $post->user_id == Auth::id() || ($user && $post->email == $user->email);
    }

    /**
     * 권한 확인
     */
    protected function hasPermission($board, $action)
    {
        $user = Auth::user();
        $permission = $board->{"permit_$action"} ?? 'public';

        // Admin/Super 회원은 모든 권한 허용
        if ($user && in_array($user->utype, ['admin', 'super'])) {
            return true;
        }

        switch ($permission) {
            case 'public':
                return true;
            case 'member':
                return Auth::check();
            case 'grade':
                // 특정 등급 확인 로직 (추후 구현)
                return Auth::check();
            case 'admin':
                return $user && in_array($user->utype, ['admin', 'super']);
            case 'owner':
                // 작성자 확인은 별도 메서드에서 처리
                return Auth::check();
            case 'none':
                return false;
            default:
                return false;
        }
    }

    /**
     * 권한 확인 (게시글별)
     */
    protected function hasPostPermission($board, $post, $action)
    {
        $user = Auth::user();
        $permission = $board->{"permit_$action"} ?? 'owner';

        // Admin/Super 회원은 모든 권한 허용
        if ($user && in_array($user->utype, ['admin', 'super'])) {
            return true;
        }

        switch ($permission) {
            case 'owner':
                return $this->isOwner($post);
            case 'member':
                return Auth::check();
            case 'grade':
                // 특정 등급 확인 로직 (추후 구현)
                return Auth::check();
            case 'admin':
                return $user && in_array($user->utype, ['admin', 'super']);
            default:
                return false;
        }
    }

    /**
     * 계층 구조 데이터를 평탄화하여 반환
     */
    protected function buildHierarchy($table, $parentId = null, $level = 0)
    {
        $items = DB::table($table)
            ->where('parent_id', $parentId)
            ->orderBy('created_at', 'desc')
            ->get();

        $result = [];

        foreach ($items as $item) {
            $item->level = $level;
            $result[] = $item;

            // 재귀적으로 하위 항목 가져오기
            $children = $this->buildHierarchy($table, $item->id, $level + 1);
            $result = array_merge($result, $children);
        }

        return $result;
    }

    /**
     * 원본 게시글만 조회 (댓글 제외)
     */
    protected function buildMainPostsOnly($table)
    {
        return DB::table($table)
            ->whereNull('parent_id') // 댓글 제외, 원본 게시글만
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray(); // Collection을 배열로 변환
    }

    /**
     * UUID로 게시글 조회 (샤딩 환경 지원)
     */
    protected function findPostByUuid($table, $uuid, $shardId = null)
    {
        $query = DB::table($table)->where('uuid', $uuid);

        if ($shardId !== null && \Illuminate\Support\Facades\Schema::hasColumn($table, 'shard_id')) {
            $query->where('shard_id', $shardId);
        }

        return $query->first();
    }

    /**
     * 사용자 UUID로 게시글 조회
     */
    protected function findPostsByUserUuid($table, $userUuid, $shardId = null)
    {
        $query = DB::table($table)->where('user_uuid', $userUuid);

        if ($shardId !== null && \Illuminate\Support\Facades\Schema::hasColumn($table, 'shard_id')) {
            $query->where('shard_id', $shardId);
        }

        return $query->get();
    }

    /**
     * 샤드 ID 기반 게시글 조회
     */
    protected function findPostsByShard($table, $shardId)
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn($table, 'shard_id')) {
            return collect();
        }

        return DB::table($table)->where('shard_id', $shardId)->get();
    }

    /**
     * JWT 인증 시도 (선택적 인증)
     */
    protected function tryJwtAuth($request)
    {
        try {
            $jwtService = app(JwtService::class);
            $token = $jwtService->getTokenFromRequest($request);

            // hidden input에서도 토큰 확인
            if (!$token && $request->has('_jwt_token')) {
                $token = $request->input('_jwt_token');
            }

            // access_token이 없으면 refresh_token 직접 사용 시도
            if (!$token && $request->cookie('refresh_token')) {
                $token = $request->cookie('refresh_token');
                \Log::info('Using refresh token as access token', [
                    'has_refresh_token' => true,
                    'refresh_token_preview' => substr($token, 0, 50) . '...',
                ]);
            }

            if (!$token) {
                return null;
            }

            $user = $jwtService->getUserFromToken($token);

            \Log::info('JWT Auth Success in BoardPermissions', [
                'user_id' => $user ? $user->id : null,
                'user_email' => $user ? $user->email : null,
                'user_name' => $user ? $user->name : null,
                'controller' => get_class($this),
            ]);

            return $user;

        } catch (\Exception $e) {
            \Log::error('JWT Auth Failed in BoardPermissions', [
                'error' => $e->getMessage(),
                'controller' => get_class($this),
                'token_preview' => $request->cookie('access_token') ? substr($request->cookie('access_token'), 0, 50) . '...' : 'no cookie',
            ]);
            return null;
        }
    }

    /**
     * JWT 또는 세션 기반 인증 설정
     */
    protected function setupAuth($request)
    {
        // JWT 인증 시도
        $jwtUser = $this->tryJwtAuth($request);

        // JWT 사용자가 있으면 Auth에 설정
        if ($jwtUser) {
            Auth::setUser($jwtUser);
        }

        return Auth::user();
    }

    /**
     * Refresh Token으로 새로운 Access Token 획득 시도
     */
    protected function tryRefreshToken($request, $jwtService)
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            if (!$refreshToken) {
                return null;
            }

            // refresh token으로 새로운 access token 생성
            $user = $jwtService->getUserFromToken($refreshToken);

            if (!$user) {
                \Log::error('Failed to get user from refresh token');
                return null;
            }

            // 새로운 access token 생성
            $newAccessToken = $jwtService->generateAccessToken($user);

            // 새로운 토큰을 쿠키에 설정 (응답에 추가)
            if (method_exists($jwtService, 'setTokenCookie')) {
                $jwtService->setTokenCookie('access_token', $newAccessToken, 60);
            }

            \Log::info('Access token refreshed successfully', [
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            return $newAccessToken;

        } catch (\Exception $e) {
            \Log::error('Token refresh failed', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}