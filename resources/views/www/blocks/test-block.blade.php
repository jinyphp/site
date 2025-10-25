<!-- Test Block for Welcome Page -->
<section class="py-5" @if(isset($blockConfig['background'])) style="background-color: {{ $blockConfig['background'] }};" @endif>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-4 fw-bold mb-4">
                    {{ $blockConfig['title'] ?? $blockName ?? 'Test Block' }}
                </h2>
                @if(isset($blockConfig['subtitle']))
                    <p class="lead mb-4">{{ $blockConfig['subtitle'] }}</p>
                @endif
                @if(isset($blockConfig['description']))
                    <p class="mb-4">{{ $blockConfig['description'] }}</p>
                @endif
                @if(isset($blockConfig['button_text']) && isset($blockConfig['button_url']))
                    <a href="{{ $blockConfig['button_url'] }}" class="btn btn-primary btn-lg">
                        {{ $blockConfig['button_text'] }}
                    </a>
                @elseif(isset($blockConfig['button_text']))
                    <button class="btn btn-primary btn-lg">
                        {{ $blockConfig['button_text'] }}
                    </button>
                @endif

                @if(config('app.debug'))
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <strong>Debug Info:</strong><br>
                            Block ID: {{ $blockId ?? 'N/A' }}<br>
                            Block Name: {{ $blockName ?? 'N/A' }}<br>
                            Config: {{ json_encode($blockConfig ?? []) }}
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>