@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">{{ $promotion->name }}</h1>
            <p>{{ $promotion->description }}</p>
            <p>Code: {{ $promotion->code }}</p>
            <p>Type: {{ $promotion->type }}</p>
            <p>Value: {{ $promotion->value }}</p>
        </div>
    </div>
</div>
@endsection
