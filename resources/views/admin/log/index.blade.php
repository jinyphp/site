@extends($layout ?? 'jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <div class="row mb-3">
        <div class="col-md-4"><div class="card p-3"><h4>{{ number_format($stats['total']) }}</h4><p>전체</p></div></div>
        <div class="col-md-4"><div class="card p-3"><h4>{{ number_format($stats['today']) }}</h4><p>오늘</p></div></div>
        <div class="col-md-4"><div class="card p-3"><h4>{{ number_format($stats['this_month']) }}</h4><p>이번달</p></div></div>
    </div>
    <div class="card">
        <table class="table">
            <thead><tr><th>연</th><th>월</th><th>일</th><th>URI</th><th>카운트</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                <tr><td>{{$log->year}}</td><td>{{$log->month}}</td><td>{{$log->day}}</td><td>{{$log->uri}}</td><td>{{$log->cnt}}</td></tr>
                @empty
                <tr><td colspan="5" class="text-center">데이터 없음</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($logs->hasPages())<div class="card-footer">{{ $logs->links() }}</div>@endif
    </div>
</div>
@endsection
