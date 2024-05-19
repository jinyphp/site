<div>
    <x-navtab class="mb-3 nav-bordered">

        <!-- formTab -->
        <x-navtab-item class="show active" >
            <x-navtab-link class="rounded-0 active">
                <span class="d-none d-md-block">Items</span>
            </x-navtab-link>
            <div class="mb-3">
                <label for="simpleinput" class="form-label">이름</label>
                <input type="text" class="form-control"
                            wire:model.defer="forms.name">
            </div>

            <div class="mb-3">
                <label for="simpleinput" class="form-label">직위</label>
                <textarea class="form-control" id="example-textarea" rows="5"
                wire:model.defer="forms.position">

                </textarea>
            </div>

            <div class="mb-3">
                <label for="simpleinput" class="form-label">사진</label>
                <input type="file" class="form-control"
                            wire:model.defer="forms.image">
                <p>
                    @if(isset($forms['image']))
                    {{$forms['image']}}
                    @endif
                </p>
            </div>
        </x-navtab-item>

        <!-- formTab -->
        {{-- <x-navtab-item>
            <x-navtab-link class="rounded-0">
                <span class="d-none d-md-block">Widget</span>
            </x-navtab-link>

            <div class="mb-3">
                <label for="simpleinput" class="form-label">메인 타이틀</label>
                <input type="text" class="form-control"
                            wire:model.defer="widget.title">
            </div>

            <div class="mb-3">
                <label for="simpleinput" class="form-label">서브 설명</label>
                <textarea class="form-control" id="example-textarea" rows="5"
                wire:model.defer="widget.subtitle">

                </textarea>
            </div>

        </x-navtab-item> --}}
    </x-navtab>

</div>
