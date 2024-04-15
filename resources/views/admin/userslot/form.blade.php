<div>
    {{-- <div class="mb-3">
        <label for="simpleinput" class="form-label">Id</label>
        <input type="text" class="form-control" id="site-code"
                    wire:model.defer="_id">
    </div> --}}

    <div class="mb-3">
        <label for="simpleinput" class="form-label">code</label>
        <input type="text" class="form-control" id="site-code"
                    placeholder="영어로 작성해 주세요"
                    wire:model.defer="form">
    </div>

</div>
