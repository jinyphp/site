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
    </div>

    <x-flex-between class="mt-2">
        <div>

        </div>
        <div>
            <button class="btn btn-primary" wire:click="submit()">적용</button>
        </div>
    </x-flex>

</div>
