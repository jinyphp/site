@extends('jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <p>{{ $config['subtitle'] }}</p>
    <div class="card">
        <table class="table">
            <thead><tr><th>제목</th><th>시작일</th><th>종료일</th></tr></thead>
            <tbody>
                @forelse($events as $e)
                <tr><td>{{$e->title}}</td><td>{{$e->start_date}}</td><td>{{$e->end_date}}</td></tr>
                @empty
                <tr><td colspan="3" class="text-center">데이터 없음</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($events->hasPages())<div class="card-footer">{{ $events->links() }}</div>@endif
    </div>
</div>
@endsection
