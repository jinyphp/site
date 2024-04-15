<div>
    <div class="mb-3">
        <label for="simpleinput" class="form-label">code</label>
        <input type="text" class="form-control" id="site-code"
                    placeholder="영어로 작성해 주세요"
                    wire:model.defer="form.name">
    </div>

    <div class="mb-3">
        <label for="simpleinput" class="form-label">Text</label>
        <textarea class="form-control" id="example-textarea" rows="5"
        wire:model.defer="form.description">

        </textarea>
    </div>


</div>
