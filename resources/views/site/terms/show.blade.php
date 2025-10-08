@extends('layouts.app')

@section('title', $terms['title'] ?? '약관')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">{{ $terms['title'] ?? '약관' }}</h1>

        @if(!empty($terms['version']))
        <p class="text-sm text-gray-500 mb-6">버전: {{ $terms['version'] }}</p>
        @endif

        <div class="prose max-w-none">
            {!! nl2br(e($terms['content'] ?? '약관 내용이 없습니다.')) !!}
        </div>
    </div>
</div>
@endsection
