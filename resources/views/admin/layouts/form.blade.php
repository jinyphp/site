<div>
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
                <x-form-label>
                    <a href="/admin/site/layout/tag">
                        테그 +
                    </a>
                </x-form-label>
                <x-form-item>
                    {!! xSelect()
                        ->table('site_layouts_tag','tag')
                        ->setWire('model.defer',"forms.tag")
                        ->setWidth("medium")
                    !!}

                    {{-- {!! xInputText()
                        ->setWire('model.defer',"forms.tag")
                        ->setWidth("standard")
                    !!} --}}
                </x-form-item>
            </x-form-hor>

            <x-form-hor>
                <x-form-label>_layouts/이름</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.name")
                        ->setWidth("standard")
                    !!}
                </x-form-item>
            </x-form-hor>

            <x-form-hor>
                <x-form-label>아이콘</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.icon")
                        ->setWidth("standard")
                    !!}
                </x-form-item>
            </x-form-hor>

        </x-navtab-item>


        <!-- formTab -->
        <x-navtab-item class="" >

            <x-navtab-link class="rounded-0 ">
                <span class="d-none d-md-block">경로</span>
            </x-navtab-link>

            <x-form-hor>
                <x-form-label>path</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.path")
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

        </x-navtab-item>

    </x-navtab>
</div>
