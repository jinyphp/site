@extends('admin.layouts.main')

@section('title', '언어 관리')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">언어 관리</h1>
        <a href="{{ route('admin.site.languages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> 언어 추가
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>코드</th>
                            <th>이름</th>
                            <th>원어 이름</th>
                            <th>활성화</th>
                            <th>작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($languages as $language)
                        <tr>
                            <td>{{ $language->code }}</td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->native_name }}</td>
                            <td>
                                @if($language->enabled)
                                <span class="badge badge-success">활성</span>
                                @else
                                <span class="badge badge-secondary">비활성</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.site.languages.show', $language->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.site.languages.edit', $language->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.site.languages.destroy', $language->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('정말 삭제하시겠습니까?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">언어가 없습니다.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $languages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
