<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 블록 생성 컨트롤러
 *
 * @description
 * 새로운 블록 파일을 생성하는 폼을 표시합니다.
 */
class CreateController extends Controller
{
    /**
     * 블록 생성 폼 표시 (서브폴더 지원)
     */
    public function __invoke(Request $request, $folder = null)
    {
        try {
            // 폴더 경로 처리
            $currentFolder = '';
            if ($folder) {
                $currentFolder = str_replace('.', '/', $folder);
            }
            // 카테고리 목록
            $categories = [
                'hero01' => 'Hero 01',
                'hero02' => 'Hero 02',
                'hero03' => 'Hero 03',
                'hero04' => 'Hero 04',
                'hero05' => 'Hero 05',
                'hero06' => 'Hero 06',
                'hero07' => 'Hero 07',
                'hero08' => 'Hero 08',
                'hero' => 'Hero',
                'about' => 'About',
                'features' => 'Features',
                'testimonials' => 'Testimonials',
                'cta' => 'Call to Action',
                'pricing' => 'Pricing',
                'courses' => 'Courses',
                'other' => 'Other',
            ];

            // 기본 템플릿들
            $templates = [
                'basic' => [
                    'name' => '기본 섹션',
                    'content' => '{{-- Basic Section Block --}}
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">Section Title</h2>
                <p class="lead text-center">Section content goes here.</p>
            </div>
        </div>
    </div>
</section>'
                ],
                'hero' => [
                    'name' => '히어로 섹션',
                    'content' => '{{-- Hero Section Block --}}
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Hero Title</h1>
                <p class="lead mb-4">Hero description text goes here.</p>
                <a href="#" class="btn btn-light btn-lg">Get Started</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400" class="img-fluid rounded" alt="Hero Image">
            </div>
        </div>
    </div>
</section>'
                ],
                'features' => [
                    'name' => '기능 섹션',
                    'content' => '{{-- Features Section Block --}}
<section class="features-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2>Our Features</h2>
                <p class="lead">What makes us special</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-star fa-3x text-primary mb-3"></i>
                    <h4>Feature One</h4>
                    <p>Feature description</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                    <h4>Feature Two</h4>
                    <p>Feature description</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                    <h4>Feature Three</h4>
                    <p>Feature description</p>
                </div>
            </div>
        </div>
    </div>
</section>'
                ],
                'cta' => [
                    'name' => 'Call to Action',
                    'content' => '{{-- Call to Action Block --}}
<section class="cta-section bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-4">Ready to Get Started?</h2>
                <p class="lead mb-4">Join thousands of satisfied customers</p>
                <a href="#" class="btn btn-primary btn-lg me-3">Get Started</a>
                <a href="#" class="btn btn-outline-light btn-lg">Learn More</a>
            </div>
        </div>
    </div>
</section>'
                ]
            ];

            return view('jiny-site::admin.blocks.create', [
                'categories' => $categories,
                'templates' => $templates,
                'currentFolder' => $currentFolder,
                'folderParam' => $folder
            ])->withErrors([]); // 빈 에러 백으로 전달

        } catch (\Exception $e) {
            return back()->withErrors(['message' => '블록 생성 페이지 로드 중 오류가 발생했습니다.']);
        }
    }
}