@extends('jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <p>{{ $config['subtitle'] }}</p>
    <div class="card">
        <table class="table">
            <thead><tr><th>ID</th><th>생성일</th></tr></thead>
            <tbody>
                @forelse($notifications as $n)
                <tr><td>{{$n->id}}</td><td>{{$n->created_at}}</td></tr>
                @empty
                <tr><td colspan="2" class="text-center">데이터 없음</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($notifications->hasPages())<div class="card-footer">{{ $notifications->links() }}</div>@endif
    </div>
</div>
@endsection
