@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'CMS 대시보드')

@section('content')
<div class="container-fluid p-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-3 mb-3">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h2 fw-bold">
                        CMS 대시보드
                    </h1>
                    <p class="mb-0">
                        콘텐츠 관리 시스템(CMS)의 주요 기능을 관리합니다.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CMS 대시보드 콘텐츠 -->
    @include('jiny-site::admin.dashboard.cms')
</div>
@endsection
