<x-navtab class="mb-3 nav-bordered">

    <!-- formTab -->
    <x-navtab-item class="show active" >

        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <div class="mb-3">
            <label for="example-palaceholder" class="form-label">하단로고 이미지</label>
            <input type="text" id="example-palaceholder" class="form-control"
            wire:model.defer="forms.logo">
            </div>

            <div class="mb-3">
                <label class="form-label" for="textInput">Copyright</label>
                <textarea class="form-control" id="example-textarea"
                    rows="10"
                    wire:model.defer="forms.copyright"></textarea>
                <p class="form-text" id="basic-addon4">
                    사이트 하단에 표시하는 copyright를 지정합니다.
                </p>
            </div>

    </x-navtab-item>

    <x-navtab-item class="show" >

        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">레이아웃</span>
        </x-navtab-link>

        <div class="mb-3">
        <label for="example-palaceholder" class="form-label">레이아웃1</label>
        <input type="text" id="example-palaceholder" class="form-control"
        wire:model.defer="forms.layout1">
        </div>

        <div class="mb-3">
            레이아웃1 과 레이아웃2 사이에는 입력한 컨덴츠가 출력됩니다.
        </div>

        <div class="mb-3">
            <label for="example-palaceholder" class="form-label">레이아웃2</label>
            <input type="text" id="example-palaceholder" class="form-control"
            wire:model.defer="forms.layout2">
        </div>
    </x-navtab-item>

</x-navtab>
