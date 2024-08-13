<x-navtab class="mb-3 nav-bordered">

    <!-- formTab -->
    <x-navtab-item class="show active" >

        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>활성화</x-form-label>
            <x-form-item>
                {!! xCheckbox()
                    ->setWire('model.defer',"forms.enable")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>uri</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.uri")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>



        <x-form-hor>
            <x-form-label>제목</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.title")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>



        <x-form-hor>
            <x-form-label>설명</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.description")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>키워드</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.keyword")
                !!}
            </x-form-item>
        </x-form-hor>


    </x-navtab-item>

    <!-- formTab -->
    {{-- <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">관리</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>담당자</x-form-label>
            <x-form-item>
                {!! xSelect()
                    ->table('site_manager','user_name')
                    ->setWire('model.defer',"forms.manager")
                    ->setWidth("standard")
                !!}


            </x-form-item>
        </x-form-hor> --}}

    </x-navtab-item>

</x-navtab>

