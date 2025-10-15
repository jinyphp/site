@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">프로모션 관리</h1>
        </div>
    </div>

    <div class="row">
        @foreach($promotions as $promotion)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $promotion->name }}</h5>
                    <p class="card-text">{{ $promotion->code }}</p>
                    <p class="card-text">{{ $promotion->description }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
