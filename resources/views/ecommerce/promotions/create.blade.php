@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">프로모션 생성</h1>

            <form method="POST" action="{{ route('admin.cms.ecommerce.promotions.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">이름</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">코드</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">설명</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">타입</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="percentage">퍼센트</option>
                        <option value="fixed_amount">고정 금액</option>
                        <option value="free_shipping">무료 배송</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">값</label>
                    <input type="number" step="0.01" class="form-control" id="value" name="value" required>
                </div>

                <div class="mb-3">
                    <label for="starts_at" class="form-label">시작일</label>
                    <input type="datetime-local" class="form-control" id="starts_at" name="starts_at" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">상태</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">활성</option>
                        <option value="inactive">비활성</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">생성</button>
            </form>
        </div>
    </div>
</div>
@endsection
