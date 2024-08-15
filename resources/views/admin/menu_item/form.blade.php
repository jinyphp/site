<div>
    {{$ref}}

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
                    <x-form-label>해더제목 </x-form-label>
                    <x-form-item>
                        {!! xCheckbox()
                            ->setAttribute('name',"header")
                            ->setWire('model.defer',"forms.header")
                        !!}
                    </x-form-item>
                </x-form-hor>

                <x-form-hor>
                    <x-form-label>제목</x-form-label>
                    <x-form-item>
                        {!! xInputText()
                            ->setAttribute('name',"title")
                            ->setWire('model.defer',"forms.title")
                            ->setWidth("standard")
                        !!}
                    </x-form-item>
                </x-form-hor>

                <x-form-hor>
                    <x-form-label>링크</x-form-label>
                    <x-form-item>
                        {!! xInputText()
                            ->setAttribute('name',"href")
                            ->setWire('model.defer',"forms.href")
                            ->setWidth("standard")
                        !!}
                    </x-form-item>
                </x-form-hor>

                <x-form-hor>
                    <x-form-label>메모</x-form-label>
                    <x-form-item>
                        {!! xTextarea()
                            ->setAttribute('name',"description")
                            ->setWire('model.defer',"forms.description")
                        !!}
                    </x-form-item>
                </x-form-hor>

            </x-navtab-item>

        </x-navtab>

</div>
