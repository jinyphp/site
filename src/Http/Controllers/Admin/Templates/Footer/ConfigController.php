<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Services\FooterService;
use Jiny\Site\Facades\Footer;

class ConfigController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * 푸터 설정 페이지 표시
     */
    public function index()
    {
        $footerConfig = [
            'copyright' => Footer::getCopyright(),
            'logo' => Footer::getLogo(),
            'company' => Footer::getCompany(),
            'social' => Footer::getSocial(),
            'menu_sections' => Footer::getMenuSections(),
        ];

        return view('jiny-site::admin.templates.footer.config', compact('footerConfig'));
    }

    /**
     * 기본 설정 (저작권, 로고) 업데이트
     */
    public function updateBasic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'copyright' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $success = $this->footerService->updateConfig([
            'copyright' => $request->copyright,
            'logo' => $request->logo,
        ]);

        if ($success) {
            return back()->with('success', '기본 설정이 업데이트되었습니다.');
        }

        return back()->with('error', '설정 업데이트에 실패했습니다.');
    }

    /**
     * 회사 정보 업데이트
     */
    public function updateCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company.name' => 'nullable|string|max:255',
            'company.description' => 'nullable|string|max:500',
            'company.email' => 'nullable|email|max:255',
            'company.phone' => 'nullable|string|max:50',
            'company.address' => 'nullable|string|max:500',
            'company.hours' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $currentData = $this->footerService->getFullJsonData();
        $currentData['company'] = $request->company ?? [];

        $success = $this->footerService->saveJsonData($currentData);

        if ($success) {
            return back()->with('success', '회사 정보가 업데이트되었습니다.');
        }

        return back()->with('error', '회사 정보 업데이트에 실패했습니다.');
    }

    /**
     * 소셜 링크 업데이트
     */
    public function updateSocial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social' => 'nullable|array',
            'social.*.platform' => 'required_with:social.*|string|max:50',
            'social.*.url' => 'required_with:social.*|url|max:255',
            'social.*.icon' => 'required_with:social.*|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $socialData = [];
        if ($request->has('social')) {
            foreach ($request->social as $social) {
                if (!empty($social['platform']) && !empty($social['url']) && !empty($social['icon'])) {
                    $socialData[] = [
                        'platform' => $social['platform'],
                        'url' => $social['url'],
                        'icon' => $social['icon'],
                    ];
                }
            }
        }

        $currentData = $this->footerService->getFullJsonData();
        $currentData['social'] = $socialData;

        $success = $this->footerService->saveJsonData($currentData);

        if ($success) {
            return back()->with('success', '소셜 링크가 업데이트되었습니다.');
        }

        return back()->with('error', '소셜 링크 업데이트에 실패했습니다.');
    }

    /**
     * 메뉴 섹션 업데이트
     */
    public function updateMenuSections(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_sections' => 'nullable|array',
            'menu_sections.*.title' => 'required_with:menu_sections.*|string|max:100',
            'menu_sections.*.links' => 'nullable|array',
            'menu_sections.*.links.*.title' => 'required_with:menu_sections.*.links.*|string|max:100',
            'menu_sections.*.links.*.href' => 'required_with:menu_sections.*.links.*|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $menuSections = [];
        if ($request->has('menu_sections')) {
            foreach ($request->menu_sections as $key => $section) {
                if (!empty($section['title'])) {
                    $links = [];
                    if (isset($section['links'])) {
                        foreach ($section['links'] as $link) {
                            if (!empty($link['title']) && !empty($link['href'])) {
                                $links[] = [
                                    'title' => $link['title'],
                                    'href' => $link['href'],
                                ];
                            }
                        }
                    }
                    $menuSections[$key] = [
                        'title' => $section['title'],
                        'links' => $links,
                    ];
                }
            }
        }

        $currentData = $this->footerService->getFullJsonData();
        $currentData['menu_sections'] = $menuSections;

        $success = $this->footerService->saveJsonData($currentData);

        if ($success) {
            return back()->with('success', '메뉴 섹션이 업데이트되었습니다.');
        }

        return back()->with('error', '메뉴 섹션 업데이트에 실패했습니다.');
    }

    /**
     * JSON 파일 직접 편집 페이지 표시
     */
    public function editJson()
    {
        $jsonContent = '';
        $jsonPath = __DIR__ . '/../../../../../config/footers.json';

        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
        }

        return view('jiny-site::admin.templates.footer.edit-json', compact('jsonContent'));
    }

    /**
     * 현재 JSON 내용을 AJAX로 반환
     */
    public function getCurrentJson()
    {
        $jsonContent = '';
        $jsonPath = __DIR__ . '/../../../../../config/footers.json';

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
        $jsonPath = __DIR__ . '/../../../../../config/footers.json';
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