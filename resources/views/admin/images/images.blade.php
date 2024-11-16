<div>
    {{-- 현재 경로 표시 --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.site.images.index') }}">images</a>
                </li>
                @php
                    $pathParts = array_filter(explode('/', request()->path ?? ''));
                    $currentPath = '';
                @endphp
                @foreach ($pathParts as $part)
                    @php $currentPath .= '/'.$part @endphp
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.site.images.index', ['path' => ltrim($currentPath, '/')]) }}">
                            {{ $part }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between gap-2 mb-3">
        <div>
            {{-- 상위 폴더로 이동 --}}

            @if ($path)
                <a href="{{ route('admin.site.images.index', ['path' => dirname($path)]) }}"
                    class="btn btn-outline-secondary">
                    상위 폴더로
                </a>
            @endif

            @if (count($directories) == 0 && count($images) == 0)
                <button class="btn btn-danger" wire:click="deleteDirectory('{{ $path }}')">
                    디렉토리 삭제
                </button>
            @endif
        </div>
        <div>
            <div class="input-group">
                <input type="text" class="form-control" wire:model="newDirectory" placeholder="새 디렉토리 이름">
                <button class="btn btn-primary" wire:click="createDirectory('{{ $path }}')">
                    디렉토리 생성
                </button>
            </div>
            @error('newDirectory')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- 폴더 목록 --}}
    <div class="row mb-4">
        @if (count($directories) > 0)

            @foreach ($directories as $directory)
                <div class="col-md-2 col-sm-3 col-4 mb-3">
                    <a href="{{ route('admin.site.images.index', ['path' => $directory['path']]) }}"
                        class="text-decoration-none text-dark">
                        <div class="d-flex align-items-center bg-white p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="me-2">
                                <path
                                    d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                            </svg>
                            <div class="text-truncate">
                                {{ $directory['name'] }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach



        @endif
    </div>

    @if ($popupDelete)
        <x-wire-dialog-modal wire:model="popupDelete" :maxWidth="$popupWindowWidth">
            <x-slot name="title">
                {{ __('폴더삭제') }}
            </x-slot>

            <x-slot name="content">
                {{ $path }} 폴더를 삭제합니다.
            </x-slot>

            <x-slot name="footer">
                <div class="d-flex justify-content-between gap-2">
                    <button type="button" class="btn btn-danger btn-sm"
                        wire:click="deleteConfirm('{{ $path }}')">삭제
                    </button>

                    <button type="button" class="btn btn-secondary btn-sm" wire:click="deleteCancel()">취소</button>
                </div>

            </x-slot>
        </x-wire-dialog-modal>
    @endif

    {{-- 이미지 목록 --}}
    @if (count($images) > 0)
        <x-ui-divider>이미지</x-ui-divider>
        <div class="row">
            @foreach ($images as $image)
                <div class="col-md-2 col-sm-3 col-4 mb-3">
                    <div class="card">
                        <img src="{{ $image['path'] }}" class="card-img-top"
                            alt="{{ $image['name'] }}">

                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text small text-truncate mb-0">
                                    {{ $image['name'] }}
                                </p>
                                <button class="btn btn-sm btn-danger"
                                    wire:click="deleteImage('{{ $image['path'] }}', '{{ $image['name'] }}')">
                                    삭제
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- 파일 업로드 섹션 --}}
    <x-ui-divider>파일 업로드</x-ui-divider>
    <div class="card mb-4">
        <div class="card-body">
            <form wire:submit.prevent="uploadImage" enctype="multipart/form-data">
                <div class="mb-3">
                    <p class="text-muted">현재 경로: {{ $current_path }}</p>
                    <label for="imageUpload" class="form-label">이미지 선택</label>
                    <div wire:loading wire:target="imageFile">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">업로드 중...</span>
                        </div>
                        <span class="text-primary ms-2">파일 업로드 중...</span>
                    </div>
                    <input type="file" class="form-control" id="imageUpload"
                        wire:model="imageFile"
                        accept="image/*"
                        wire:loading.attr="disabled">
                    @error('imageFile')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled"
                    wire:loading.class="disabled">
                    <span wire:loading.remove wire:target="uploadImage">업로드</span>
                    <span wire:loading wire:target="uploadImage">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        업로드 중...
                    </span>
                </button>
            </form>
        </div>
    </div>

    {{-- 파일 삭제 팝업 --}}
    @if ($popupDeletePath)
        <x-wire-dialog-modal wire:model="popupDeletePath" :maxWidth="$popupWindowWidth">
            <x-slot name="title">
                {{ __('파일삭제') }}
            </x-slot>

            <x-slot name="content">
                {{$deleteFileName}} 파일을 삭제합니다.
            </x-slot>

            <x-slot name="footer">
                <div class="d-flex justify-content-between gap-2">
                    <button type="button" class="btn btn-danger btn-sm"
                        wire:click="deleteImageConfirm('{{ $image['path'] }}', '{{ $image['name'] }}')">삭제
                    </button>

                    <button type="button" class="btn btn-secondary btn-sm"
                    wire:click="deleteCancel()">취소</button>
                </div>

            </x-slot>
        </x-wire-dialog-modal>
    @endif
</div>
