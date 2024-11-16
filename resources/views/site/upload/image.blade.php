<section>

    {{-- 이미지 목록 --}}
    <article class="p-4 border border-dashed bg-gray-100">
        <div class="grid grid-cols-4 gap-4">
            @forelse ($images as $image)
                <div class="relative group col-span-4 md:col-span-1">

                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ $image['url'] }}" alt="{{ $image['alt'] ?? '이미지' }}"
                            class="w-full h-full object-cover rounded-lg cursor-pointer"
                            onclick="copyToClipboard('{{ $image['url'] }}')" title="클릭하여 URL 복사">
                    </div>

                    <div class="mt-2 text-sm flex justify-between items-center px-2">
                        <span class="cursor-pointer" onclick="copyToClipboard('{{ $image['url'] }}')"
                            title="클릭하여 URL 복사">
                            {{ $image['filename'] ?? '' }}
                        </span>

                        <a href="javascript:void(0)"
                            wire:click="deleteImage('{{ $image['url'] }}', '{{ $image['filename'] }}')"
                            class="text-red-500 hover:text-red-700 whitespace-nowrap">
                            삭제
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-gray-500">
                    등록된 이미지가 없습니다.
                </div>
            @endforelse
        </div>
    </article>

    {{-- 이미지 업로드 --}}
    <form id="dropzone" class="border border-dashed bg-gray-200">
        @csrf
        <div class="px-4 py-2 dropzone">
            <div class="d-flex justify-content-between align-items-center">
                <span>업로드할 이미지 파일을 여기에 드레그 하세요.
                    또는,이미지를 붙여넣기 하세요 (Ctrl + V)</span>

                <div>
                    <div class="input-group">
                        <input type="file" class="form-control" id="imageUpload" wire:model.live="imageFile"
                            accept="image/*" wire:loading.attr="disabled">

                        <button type="button" wire:click="uploadImage" class="btn btn-primary h-10"
                            wire:loading.attr="disabled" wire:loading.class="disabled">
                            <span wire:loading.remove wire:target="uploadImage">업로드</span>
                            <span wire:loading wire:target="uploadImage" class="inline-flex items-center">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="ml-1">업로드 중...</span>
                            </span>
                        </button>
                    </div>

                    <div wire:loading wire:target="imageFile" class="inline-flex items-center ml-2">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">업로드 중...</span>
                        </div>
                        <span class="text-primary ms-2">파일 업로드 중...</span>
                    </div>

                    @error('imageFile')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="progress-area"></div>
    </form>


    {{-- 삭제 확인 팝업 --}}
    @if ($popupDeletePath)
        <x-wire-dialog-modal wire:model="popupDeletePath" :maxWidth="$popupWindowWidth">
            <x-slot name="title">
                {{ __('이미지 삭제 확인') }}
            </x-slot>

            <x-slot name="content">
                <p class="mb-4">'{{ $deleteFileName }}' 파일을 삭제하시겠습니까?</p>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('popupDeletePath', false)" class="btn btn-secondary">
                        취소
                    </button>
                    <button wire:click="deleteImageConfirm('{{ $fullPath }}', '{{ $deleteFileName }}')"
                        class="btn btn-danger">
                        삭제
                    </button>
                </div>
            </x-slot>
        </x-wire-dialog-modal>
        {{-- <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg">


            </div>
        </div> --}}
    @endif

    {{-- 이미지 첨부 --}}
    <script>
        function copyToClipboard(text) {
            // 이미지 태그 생성
            const imgTag = `<img src="${text}" alt="${text.split('/').pop()}">`;

            navigator.clipboard.writeText(imgTag).then(() => {
                alert('이미지 태그가 클립보드에 복사되었습니다.');
            }).catch(err => {
                console.error('클립보드 복사 실패:', err);
                alert('이미지 태그 복사에 실패했습니다.');
            });
        }
    </script>


    @script
        <script>
            const dropzone = document.getElementById('dropzone');
            var progressArea = dropzone.querySelector(".progress-area");
            let token = dropzone.querySelector('input[name=_token]').value;

            dropzone.addEventListener('drop', function(e) {
                e.preventDefault();

                let target = e.target;
                while (!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.remove("dragover");

                var files = e.dataTransfer.files;
                for (let i = 0; i < e.dataTransfer.files.length; i++) {
                    //console.log(e.dataTransfer.files[i]);
                    uploadFile(e.dataTransfer.files[i]);
                }
            });

            dropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (dragStart) return;
                let target = e.target;
                while (!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.add("dragover");

                //console.log("drag over...");
            });

            dropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                let target = e.target;
                while (!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.remove("dragover");
            });

            // 파일 업로드
            function uploadFile(file) {
                var name = file.name;

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/api/upload/images");

                let data = new FormData();
                data.append('file[]', file);
                data.append('_token', token);

                // path 값을 직접 설정
                data.append('path', '{{ $path }}');

                xhr.upload.addEventListener("progress", ({
                    loaded,
                    total
                }) => {
                    let fileLoaded = Math.floor((loaded / total) * 100);
                    let fileTotal = Math.floor(total / 1000);
                    let fileSize;
                    (fileTotal < 1024) ? fileSize = fileTotal + " KB": fileSize = (loaded / (1024 * 1024)).toFixed(2) +
                        " MB";

                    //console.log(name + "=" + fileSize);

                    let progressHTML = `<div class="details">
                            <span class="name">` + name + `</span>
                            <span class="percent">` + " : " + fileLoaded + `%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: ` + fileLoaded + `%"></div>
                        </div>`;
                    progressArea.innerHTML = progressHTML;
                });

                xhr.onload = function() {
                    var data = JSON.parse(this.responseText);
                    //console.log(data);

                    // 페이지 갱신
                    //location.reload();
                    //console.log('image-updated');
                    $wire.dispatch('image-updated');

                }

                xhr.send(data);
            }


            // 붙여넣기 이벤트 감지
            document.addEventListener('paste', function(e) {
                const items = e.clipboardData.items;
                //console.log("이미지 클립보드 감지");

                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        console.log("이미지 파일 추출");

                        // 이미지 파일 추출
                        const blob = items[i].getAsFile();

                        // FormData 생성
                        const formData = new FormData();
                        formData.append('image', blob);

                        // 업로드 경로 추가
                        formData.append('path', '{{ $path }}');

                        // CSRF 토큰 추가
                        formData.append('_token', '{{ csrf_token() }}');

                        // 클립보드 Ajax 업로드
                        fetch('/api/upload/clip', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {

                                    //console.log('image-paste-updated');
                                    $wire.dispatch('image-updated');

                                    //console.log('이미지가 성공적으로 업로드되었습니다.');

                                    //console.log(result);
                                } else {
                                    console.error('이미지 업로드 실패:', result.message);
                                }
                            })
                            .catch(error => {
                                console.error('업로드 중 오류 발생:', error);
                            });
                    }
                }
            });
        </script>
    @endscript

</section>
