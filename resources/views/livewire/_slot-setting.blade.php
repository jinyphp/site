<div>




            <div class="mt-3">
                @foreach ($slots as $key => $item)
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="site-slot-{{$key}}"
                        wire:model="selectedSlot"
                        {{-- wire:click="selectSlot('{{ $key }}')" --}}
                        value="{{ $key }}">
                    <label class="form-check-label" for="site-slot-{{$key}}"> {{$item['name']}}</label>
                    <x-form-text for="site-slot-{{$key}}">
                        : {{$item['description']}}
                    </x-form-text>
                </div>
                @endforeach

                @if($add_slot)
                <hr>
                <div class="form-horizontal">
                    <div class="row mb-3">
                        <label for="site-code" class="col-3 col-form-label">코드명</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="site-code"
                                placeholder="영어로 작성해 주세요"
                                wire:model.defer="form.name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="site-description" class="col-3 col-form-label">설명</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="site-description"
                                wire:model.defer="form.description">
                        </div>
                    </div>
                </div>


                @endif
            </div>
            <x-flex-between class="mt-2">
                <div>
                    @if(!$add_slot)
                    <x-click wire:click="newSlot()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                    </x-click>
                    @endif
                </div>
                <div>
                    @if($add_slot)
                    <button class="btn btn-info" wire:click="addSlot()">추가</button>
                    @else
                    <button class="btn btn-primary" wire:click="submit()">적용</button>
                    @endif
                </div>
            </x-flex>


</div>
