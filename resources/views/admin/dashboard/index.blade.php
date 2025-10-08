@extends('admin.layouts.main')

@section('title', '사이트 대시보드')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">사이트 대시보드</h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                전체 방문 수</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistics['total_visits'] ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                오늘 방문 수</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistics['today_visits'] ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                전체 페이지</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistics['total_pages'] ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                전체 메뉴</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistics['total_menus'] ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">최근 로그</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>날짜</th>
                                    <th>URI</th>
                                    <th>방문 수</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistics['recent_logs'] ?? [] as $log)
                                <tr>
                                    <td>{{ $log->year }}-{{ $log->month }}-{{ $log->day }}</td>
                                    <td>{{ $log->uri }}</td>
                                    <td>{{ number_format($log->cnt) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">로그가 없습니다.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
