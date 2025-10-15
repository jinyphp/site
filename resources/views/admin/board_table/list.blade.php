@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '게시글 목록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ $config['title'] ?? '게시글 목록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.table.create') }}" class="btn btn-primary">
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
                            <th>타이틀</th>
                            <th width='200'>작성자</th>
                            <th width='100'>조회수</th>
                            <th width='200'>등록일자</th>
                            <th width='150'>작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $item)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{$item->title}}</strong>
                                    </div>
                                    <div class="text-muted small">
                                        {{$item->content}}
                                    </div>
                                </td>
                                <td width='200'>{{$item->name ?? '-'}}</td>
                                <td width='100'>
                                    <span class="badge bg-secondary">{{$item->click ?? 0}}</span>
                                </td>
                                <td width='200'>
                                    <small class="text-muted">{{$item->created_at}}</small>
                                </td>
                                <td width='150'>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.cms.board.table.edit', $item->id) }}"
                                           class="btn btn-outline-primary" title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cms.board.table.destroy', $item->id) }}"
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
                                <td colspan="5" class="text-center py-4 text-muted">
                                    등록된 게시글이 없습니다.
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
