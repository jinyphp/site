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
                <x-form-label>Route</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.route")
                        ->setWidth("standard")
                    !!}
                </x-form-item>
            </x-form-hor>

            <x-form-hor>
                <x-form-label>타입</x-form-label>
                <x-form-item>
                    {!! xSelect()
                        ->option("동작을 선택하세요")
                        ->option("정적리소스",'view')
                        ->option("마크다운",'markdown')
                        ->option("포스트",'post')

                        ->option("테이블",'table')
                        ->option("폼",'form')
                        ->setId("typeSelect")
                        ->setWire('model.defer',"forms.type")
                    !!}
                </x-form-item>
            </x-form-hor>




            <x-form-hor>
                <x-form-label>타이틀</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.title")
                    !!}
                </x-form-item>
            </x-form-hor>

            <div id="element-post" style="display: none;">
                <x-form-hor>
                    <x-form-label>포스트연결</x-form-label>
                    <x-form-item>
                        {!! xSelect()
                            ->table('site_posts','title')
                            ->setWire('model.defer',"forms.post")
                            ->setWidth("medium")
                        !!}
                    </x-form-item>
                </x-form-hor>
            </div>

            <div id="element-path" style="display: none;">
                <x-form-hor>
                    <x-form-label>리소스경로</x-form-label>
                    <x-form-item>
                        {!! xInputText()
                            ->setWire('model.defer',"forms.path")
                        !!}
                    </x-form-item>
                </x-form-hor>
            </div>

        </x-navtab-item>


        <!-- formTab -->
        <x-navtab-item >
            <x-navtab-link class="rounded-0">
                <span class="d-none d-md-block">메모</span>
            </x-navtab-link>

            <x-form-hor>
                <x-form-label>메모</x-form-label>
                <x-form-item>
                    {!! xTextarea()
                        ->setWire('model.defer',"forms.description")
                    !!}
                </x-form-item>
            </x-form-hor>

        </x-navtab-item>

    </x-navtab>

    <script>
        document.getElementById('typeSelect').addEventListener('change', function(event) {
        var selectedValue = event.target.value;
        var key = selectedValue.split(':')[0].trim();
        console.log(key);

        var element_post = document.getElementById('element-post');
        if (key === 'post') {
            element_post.style.display = 'block';
        } else {
            element_post.style.display = 'none';
        }

        var element_path = document.getElementById('element-path');
        if (key !== 'post') {
            element_path.style.display = 'block';
        } else {
            element_path.style.display = 'none';
        }
    });
    </script>

</div>
