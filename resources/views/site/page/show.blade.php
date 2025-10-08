@extends('layouts.app')

@section('title', $page['title'] ?? '페이지')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">{{ $page['title'] ?? '페이지' }}</h1>

        @if(!empty($page['content']))
        <div class="prose max-w-none">
            {!! $page['content'] !!}
        </div>
        @else
        <p class="text-gray-500">페이지 내용이 없습니다.</p>
        @endif
    </div>
</div>
@endsection
