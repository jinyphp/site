@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">프로모션 수정</h1>

            <form method="POST" action="{{ route('admin.cms.ecommerce.promotions.update', $promotion->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">이름</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $promotion->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">코드</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ $promotion->code }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">설명</label>
                    <textarea class="form-control" id="description" name="description">{{ $promotion->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">타입</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="percentage" {{ $promotion->type === 'percentage' ? 'selected' : '' }}>퍼센트</option>
                        <option value="fixed_amount" {{ $promotion->type === 'fixed_amount' ? 'selected' : '' }}>고정 금액</option>
                        <option value="free_shipping" {{ $promotion->type === 'free_shipping' ? 'selected' : '' }}>무료 배송</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">값</label>
                    <input type="number" step="0.01" class="form-control" id="value" name="value" value="{{ $promotion->value }}" required>
                </div>

                <div class="mb-3">
                    <label for="starts_at" class="form-label">시작일</label>
                    <input type="datetime-local" class="form-control" id="starts_at" name="starts_at" value="{{ $promotion->starts_at->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">상태</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" {{ $promotion->status === 'active' ? 'selected' : '' }}>활성</option>
                        <option value="inactive" {{ $promotion->status === 'inactive' ? 'selected' : '' }}>비활성</option>
                        <option value="expired" {{ $promotion->status === 'expired' ? 'selected' : '' }}>만료</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">수정</button>
            </form>
        </div>
    </div>
</div>
@endsection
