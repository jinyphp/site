<x-navtab class="mb-3 nav-bordered">

    <!-- formTab -->
    <x-navtab-item class="show active" >

        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <div class="mb-3">
            <label for="example-palaceholder" class="form-label">사이트명</label>
            <input type="text" id="example-palaceholder" class="form-control"
            wire:model.defer="forms.title">
        </div>

        <div class="mb-3">
            <label for="example-palaceholder" class="form-label">상단로고 이미지</label>
            <input type="text" id="example-palaceholder" class="form-control"
            wire:model.defer="forms.logo">
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
