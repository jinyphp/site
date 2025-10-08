@extends('jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <p>{{ $config['subtitle'] }}</p>
    <div class="card">
        <table class="table">
            <thead><tr><th>ID</th><th>등록일</th></tr></thead>
            <tbody>
                @forelse($banners as $b)
                <tr><td>{{$b->id}}</td><td>{{$b->created_at}}</td></tr>
                @empty
                <tr><td colspan="2" class="text-center">데이터 없음</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($banners->hasPages())<div class="card-footer">{{ $banners->links() }}</div>@endif
    </div>
</div>
@endsection
