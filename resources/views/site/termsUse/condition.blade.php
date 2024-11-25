<div class="d-flex justify-content-between">
    <h2 class="h2 mt-4">
        {{$term['title']}}
    </h2>
    {{-- <div>
        @if($design)
        <button class="btn btn-info" wire:click="contentEdit()">Edit</button>
        @endif
    </div> --}}
</div>

{{-- <hr class="mt-0"> --}}

<div class="h6 pt-2 pt-lg-3">
    <span class="text-body-secondary fw-medium">최종 업데이트:</span>
    {{$term['updated_at']}}
</div>

@includeIf($termBlade)

<div class="d-flex justify-content-between">
    <h2 class="h2 mt-4">
        {{-- {{$term['title']}} --}}
    </h2>
    <div>
        {{-- 약관 수정 버튼 --}}
        @if($design)
        <button class="btn btn-info" wire:click="contentEdit()">Edit</button>
        @endif
    </div>
</div>
