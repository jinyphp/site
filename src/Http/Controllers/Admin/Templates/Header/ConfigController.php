<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Services\HeaderService;
use Jiny\Site\Facades\Header;

class ConfigController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    /**
     * 헤더 설정 페이지 표시
     */
    public function index()
    {
        $headerConfig = [
            'logo' => Header::getLogo(),
            'brand' => Header::getBrand(),
            'brand_name' => Header::getBrandName(),
            'brand_tagline' => Header::getBrandTagline(),
            'search' => Header::getSearch(),
            'navigation' => Header::getNavigation(),
            'settings' => Header::getSettings(),
        ];

        return view('jiny-site::admin.templates.header.config', compact('headerConfig'));
    }

    /**
     * 기본 설정 (로고, 브랜드명, 태그라인) 업데이트
     */
    public function updateBasic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'search' => 'nullable|string|max:255',
            'brand_tagline' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $success = $this->headerService->updateConfig([
            'logo' => $request->logo,
            'brand' => $request->brand,
            'search' => $request->search,
            'brand_tagline' => $request->brand_tagline,
        ]);

        if ($success) {
            return back()->with('success', '기본 설정이 업데이트되었습니다.');
        }

        return back()->with('error', '설정 업데이트에 실패했습니다.');
    }

    /**
     * 내비게이션 업데이트
     */
    public function updateNavigation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'navigation.primary' => 'nullable|array',
            'navigation.primary.*.title' => 'required_with:navigation.primary.*|string|max:100',
            'navigation.primary.*.href' => 'required_with:navigation.primary.*|string|max:255',
            'navigation.primary.*.active' => 'boolean',
            'navigation.secondary' => 'nullable|array',
            'navigation.secondary.*.title' => 'required_with:navigation.secondary.*|string|max:100',
            'navigation.secondary.*.href' => 'required_with:navigation.secondary.*|string|max:255',
            'navigation.secondary.*.active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $navigationData = [
            'primary' => [],
            'secondary' => []
        ];

        // Primary navigation 처리
        if ($request->has('navigation.primary')) {
            foreach ($request->input('navigation.primary') as $nav) {
                if (!empty($nav['title']) && !empty($nav['href'])) {
                    $navigationData['primary'][] = [
                        'title' => $nav['title'],
                        'href' => $nav['href'],
                        'active' => isset($nav['active']),
                    ];
                }
            }
        }

        // Secondary navigation 처리
        if ($request->has('navigation.secondary')) {
            foreach ($request->input('navigation.secondary') as $nav) {
                if (!empty($nav['title']) && !empty($nav['href'])) {
                    $navigationData['secondary'][] = [
                        'title' => $nav['title'],
                        'href' => $nav['href'],
                        'active' => isset($nav['active']),
                    ];
                }
            }
        }

        $currentData = $this->headerService->getFullJsonData();
        $currentData['navigation'] = $navigationData;

        $success = $this->headerService->saveJsonData($currentData);

        if ($success) {
            return back()->with('success', '내비게이션이 업데이트되었습니다.');
        }

        return back()->with('error', '내비게이션 업데이트에 실패했습니다.');
    }

    /**
     * 헤더 설정 업데이트
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settings.search_enabled' => 'boolean',
            'settings.notifications_enabled' => 'boolean',
            'settings.user_menu_enabled' => 'boolean',
            'settings.dark_mode_toggle' => 'boolean',
            'settings.sticky_header' => 'boolean',
            'settings.mobile_menu_style' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $settingsData = [
            'search_enabled' => $request->boolean('settings.search_enabled'),
            'notifications_enabled' => $request->boolean('settings.notifications_enabled'),
            'user_menu_enabled' => $request->boolean('settings.user_menu_enabled'),
            'dark_mode_toggle' => $request->boolean('settings.dark_mode_toggle'),
            'sticky_header' => $request->boolean('settings.sticky_header'),
            'mobile_menu_style' => $request->input('settings.mobile_menu_style', 'sidebar'),
        ];

        $currentData = $this->headerService->getFullJsonData();
        $currentData['settings'] = $settingsData;

        $success = $this->headerService->saveJsonData($currentData);

        if ($success) {
            return back()->with('success', '헤더 설정이 업데이트되었습니다.');
        }

        return back()->with('error', '헤더 설정 업데이트에 실패했습니다.');
    }

    /**
     * JSON 파일 직접 편집 페이지 표시
     */
    public function editJson()
    {
        $jsonContent = '';
        $jsonPath = __DIR__ . '/../../../../../config/headers.json';

        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
        }

        return view('jiny-site::admin.templates.header.edit-json', compact('jsonContent'));
    }

    /**
     * 현재 JSON 내용을 AJAX로 반환
     */
    public function getCurrentJson()
    {
        $jsonContent = '';
        $jsonPath = __DIR__ . '/../../../../../config/headers.json';

        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
        }

        return response()->json([
            'content' => $jsonContent
        ]);
    }

    /**
     * JSON 파일 직접 업데이트
     */
    public function updateJson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'json_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // JSON 유효성 검사
        $decodedJson = json_decode($request->json_content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['json_content' => 'JSON 형식이 올바르지 않습니다: ' . json_last_error_msg()])->withInput();
        }

        // JSON 파일 저장
        $jsonPath = __DIR__ . '/../../../../../config/headers.json';
        $success = file_put_contents($jsonPath, $request->json_content);

        if ($success !== false) {
            return back()->with('success', 'JSON 파일이 성공적으로 업데이트되었습니다.');
        }

        return back()->with('error', 'JSON 파일 저장에 실패했습니다.');
    }

    /**
     * JSON 형식 검증 (AJAX)
     */
    public function validateJson(Request $request)
    {
        $jsonContent = $request->input('json_content', '');

        $decodedJson = json_decode($jsonContent, true);
        $isValid = json_last_error() === JSON_ERROR_NONE;

        return response()->json([
            'valid' => $isValid,
            'error' => $isValid ? null : json_last_error_msg(),
            'formatted' => $isValid ? json_encode($decodedJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null
        ]);
    }
}