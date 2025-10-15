@extends($layout ?? 'jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <p>{{ $config['subtitle'] }}</p>
    <div class="row">
        <div class="col-md-4"><div class="card p-3"><h3>{{ number_format($stats['total_pages']) }}</h3><p>전체 페이지</p></div></div>
        <div class="col-md-4"><div class="card p-3"><h3>{{ number_format($stats['total_visits']) }}</h3><p>총 방문</p></div></div>
        <div class="col-md-4"><div class="card p-3"><h3>{{ number_format($stats['today_visits']) }}</h3><p>오늘 방문</p></div></div>
    </div>
</div>
@endsection
