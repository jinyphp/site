<div class="text-center">
    <h2 class="fw-bolder">
        @if(isset($widget['title']))
        {{$widget['title']}}
        @endif
    </h2>
    <p class="lead fw-normal text-muted mb-5">
        @if(isset($widget['subtitle']))
        {{$widget['subtitle']}}
        @endif
    </p>
</div>

    <div class="accordion" id="accordionPanelsStayOpen-Faq">
        @foreach ($rows as $i => $item)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapse-{{$i}}"
                    aria-expanded="false"
                    aria-controls="panelsStayOpen-collapse-{{$i}}">

                    <span>
                        {{$item['question']}}
                    </span>



                </button>
            </h2>
            <div id="panelsStayOpen-collapse-{{$i}}"
                class="accordion-collapse collapse">
              <div class="accordion-body">
                <x-flex-between class="gap-2">
                    <div>
                        {{$item['answer']}}
                    </div>

                    @if($design)
                    <span wire:click="edit({{$i}})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </span>
                    @endif
                </x-flex-between>
              </div>
            </div>
        </div>
        @endforeach
    </div>

