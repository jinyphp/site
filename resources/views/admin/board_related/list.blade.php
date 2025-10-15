@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '관련글 목록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ $config['title'] ?? '관련글 목록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.related.create') }}" class="btn btn-primary">
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
                            <th width='200'>계시판</th>
                            <th width='100'>글번호</th>
                            <th>연관</th>
                            <th width='200'>연관글</th>
                            <th width='200'>등록일자</th>
                            <th width='150'>작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $item)
                            <tr>
                                <td width='200'>{{$item->code}}</td>
                                <td width='100'>{{$item->post_id}}</td>
                                <td>{{$item->related}}</td>
                                <td width='200'>{{$item->related_id}}</td>
                                <td width='200'>
                                    <small class="text-muted">{{$item->created_at}}</small>
                                </td>
                                <td width='150'>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.cms.board.related.edit', $item->id) }}"
                                           class="btn btn-outline-primary" title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cms.board.related.destroy', $item->id) }}"
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
                                <td colspan="6" class="text-center py-4 text-muted">
                                    등록된 관련글이 없습니다.
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
