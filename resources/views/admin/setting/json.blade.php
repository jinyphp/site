<div>

    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            @if($addKeyStatus)
            <label class="form-label">키 이름</label>
            <div class="row row-cols-md-auto align-items-center">
                <div class="col-12">
                    {!! xInputText()
                        ->setWire('model.defer',"key_name")
                        ->setWidth("standard")
                    !!}
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" wire:click="addNewSubmit">추가</button>
                </div>

                <div class="col-12">
                    <button class="btn btn-secondary" wire:click="addNewCancel">취소</button>
                </div>
            </div>
            <p>새로운 데이터 항목을 추가합니다.</p>

            @else
            @foreach($forms as $key => $value)
                @if($key != "updated_at")
                    <div class="mb-3 row">
                        <label class="col-form-label col-sm-2 text-sm-end">{{$key}}</label>
                        <div class="col-sm-8">
                            {!! xInputText()
                                ->setWire('model.defer',"forms.".$key)
                            !!}

                        </div>
                        <div class="col-sm-2">
                            <x-click wire:click="itemRemove('{{$key}}')">
                                delete
                            </x-click>
                        </div>
                    </div>
                @endif
            @endforeach

            @endif
        </div>

        <div class="card-footer border-top">
            <div class="flex justify-between">
                <div>
                    <button class="btn btn-info" wire:click="addNewCreate()">+ 추가</button>
                </div>
                <div class="text-right">
                    <x-button primary wire:click="save">저장</x-button>
                </div>
            </div>
        </div>
    </div>
</div>
