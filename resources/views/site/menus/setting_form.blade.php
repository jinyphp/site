<x-navtab class="mb-3 nav-bordered">

    <x-navtab-item class="show active" >
        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>메뉴</x-form-label>
            <x-form-item>
                {!! xSelect()
                    ->table('site_menus','code')
                    ->setWire('model.defer',"forms.code")
                    ->setWidth("medium")
                !!}
            </x-form-item>
        </x-form-hor>


    </x-navtab-item>


    <x-navtab-item>
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">디자인</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>Root Item</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.root")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>Header</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.header")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>Item</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.item")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>Sub Item</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.item")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

</x-navtab>
