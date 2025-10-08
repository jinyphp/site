@extends('jiny-site::layouts.admin.sidebar')

@section('title', '게시판 목록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ $config['title'] ?? '게시판 목록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.list.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> 신규 등록
            </a>
        </div>
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width='200'>코드</th>
                            <th width='100'>포스트</th>
                            <th width='120'>조회수</th>
                            <th>타이틀</th>
                            <th width='200'>디자인</th>
                            <th width='200'>담당자</th>
                            <th width='200'>등록일자</th>
                            <th width='150'>작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $item)
                            <tr>
                                <td width='200'>
                                    <div class="d-flex gap-2">
                                        <div>
                                            <div class="text-muted small">{{$item->slug}}</div>
                                            <a href="{{ route('admin.cms.board.posts', $item->code) }}">
                                                <code>{{$item->code}}</code>
                                            </a>
                                        </div>
                                        <a href="/board/{{$item->code}}" target="_blank" title="미리보기">
                                            <i class="bi bi-arrow-up-right-square"></i>
                                        </a>
                                    </div>
                                </td>
                                <td width='100'>
                                    <a href="{{ route('admin.cms.board.posts', $item->code) }}">
                                        <span class="badge bg-secondary">{{$item->post_count ?? 0}}</span>
                                    </a>
                                </td>
                                <td width='120'>
                                    <span class="badge bg-primary">{{number_format($item->total_views ?? 0)}}</span>
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ route('admin.cms.board.posts', $item->code) }}" class="text-decoration-none">
                                            <strong>{{$item->title}}</strong>
                                        </a>
                                    </div>
                                    <div class="text-muted small">
                                        {{$item->subtitle}}
                                    </div>
                                </td>
                                <td width='200'>
                                    <span class="text-muted">{{$item->view_layout ?? '-'}}</span>
                                </td>
                                <td width='200'>{{$item->manager ?? '-'}}</td>
                                <td width='200'>
                                    <small class="text-muted">{{$item->created_at}}</small>
                                </td>
                                <td width='150'>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.cms.board.list.edit', $item->id) }}"
                                           class="btn btn-outline-primary" title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cms.board.list.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('정말 삭제하시겠습니까?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="삭제">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    등록된 게시판이 없습니다.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($rows, 'links'))
                <div class="mt-3">
                    {{ $rows->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
