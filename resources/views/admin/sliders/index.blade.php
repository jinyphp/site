@extends('jiny-site::layouts.admin.sidebar')
@section('title', $config['title'])
@section('content')
<div class="container-fluid p-6">
    <h1>{{ $config['title'] }}</h1>
    <p>{{ $config['subtitle'] }}</p>
    <div class="card">
        <table class="table">
            <thead><tr><th>순서</th><th>제목</th><th>이미지</th><th>링크</th></tr></thead>
            <tbody>
                @forelse($sliders as $s)
                <tr><td>{{$s->order}}</td><td>{{$s->title}}</td><td>{{$s->image}}</td><td>{{$s->link}}</td></tr>
                @empty
                <tr><td colspan="4" class="text-center">데이터 없음</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($sliders->hasPages())<div class="card-footer">{{ $sliders->links() }}</div>@endif
    </div>
</div>
@endsection
