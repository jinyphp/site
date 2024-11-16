<div>
    {{-- 현재 경로 표시 --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.site.actions.index') }}">Action</a>
                </li>
                @php
                    $pathParts = array_filter(explode('/', request()->path ?? ''));
                    $currentPath = '';
                @endphp
                @foreach ($pathParts as $part)
                    @php $currentPath .= '/'.$part @endphp
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.site.actions.index', ['path' => ltrim($currentPath, '/')]) }}">
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
                <a href="{{ route('admin.site.actions.index', ['path' => dirname($path)]) }}"
                    class="btn btn-outline-secondary">
                    상위 폴더로
                </a>
            @endif

            @if (count($directories) == 0 && count($files) == 0)
                <button class="btn btn-danger" wire:click="deleteDirectory('{{ $path }}')">
                    디렉토리 삭제
                </button>
            @endif
        </div>

    </div>


    <div class="row">
        <div class="col-3">
            {{-- 폴더 목록 --}}
            <div class="card">
                <div class="card-body">
                    @if (count($directories) > 0)
                        @foreach ($directories as $directory)
                            <div>
                                <a href="{{ route('admin.site.actions.index', ['path' => $directory['path']]) }}">
                                    {{ $directory['name'] }}
                                </a>
                            </div>
                        @endforeach
                    @endif

                    <div class="mt-3">
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

                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click="deleteCancel()">취소</button>
                        </div>

                    </x-slot>
                </x-wire-dialog-modal>
            @endif


        </div>
        <div class="col-9">
            {{-- json 목록 --}}
            <div class="card">
                <div class="card-body">
                    @if (count($files) > 0)
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            @foreach ($files as $file)
                                <div class="col">

                                        <div >
                                            <p >
                                                {{ $file['name'] }}
                                            </p>
                                            {{-- <button class="btn btn-sm btn-danger w-100"
                                                wire:click="deleteImage('{{ $file['path'] }}', '{{ $file['name'] }}')">
                                                삭제
                                            </button> --}}
                                        </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>


            {{-- 파일 삭제 팝업 --}}
            @if ($popupDeletePath)
                <x-wire-dialog-modal wire:model="popupDeletePath" :maxWidth="$popupWindowWidth">
                    <x-slot name="title">
                        {{ __('파일삭제') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ $deleteFileName }} 파일을 삭제합니다.
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

    </div>
</div>
