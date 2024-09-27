@if($editable)
    <div class="d-flex justify-content-between">
        <h1 class="h2 mt-4">
            {{$term['title']}}
        </h1>
        <div>
            <button class="btn btn-primary" wire:click="updateContent">확인</button>
        </div>
    </div>

    <div class="h6 pt-2 pt-lg-3">
        <span class="text-body-secondary fw-medium">Last updated:</span>
        {{$term['updated_at']}}
    </div>

    <div class="py-2">
        {!! xTextarea()
            ->setWire('model.defer',"content")
            ->setAttribute('rows',30)
        !!}
    </div>


@else
    @includeIf("jiny-site::site.termsUse.condition")
@endif

