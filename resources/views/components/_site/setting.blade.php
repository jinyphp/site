<style>
    .floating-buttons {
        transform: translateX(50%) rotate(-90deg);
    }
    .animate-rotate:hover .animate-target, .animate-rotate:focus-visible .animate-target {
        animation: rotate 0.45s ease-in-out;
    }

    .top-40 {
        top: 500px; !important;
    }

    .custom-offcanvas-width {
    min-width: 30%; !important; /* Set the width to 30% */
    max-width: none !important; /* Remove the default max-width constraint */
}
</style>

<!-- Customizer toggle -->
<div class="floating-buttons position-fixed top-40 end-0 z-sticky me-3 me-xl-4 pb-4">
    <button class="btn btn-sm
        btn-outline-success
        text-uppercase bg-body
        rounded-pill shadow
        animate-rotate ms-2 me-n5"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvas-right-site-setting"
        aria-controls="offcanvas-right-site-setting"
    style="font-size: .625rem; letter-spacing: .05rem;"
    role="button" aria-controls="customizer">
        Setting
        <i class="ci-settings fs-base ms-1 me-n2 animate-target"></i>
    </button>
</div>


<div class="offcanvas offcanvas-end custom-offcanvas-width"
    tabindex="-1"
    id="offcanvas-right-site-setting"
    aria-labelledby="offcanvas-right-site-setting">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Site Design Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <div class="card">
            <div class="card-body">
                <h4 class="header-title">슬롯변경</h4>
                <p class="text-muted font-14">
                    슬롯을 변경하여 사이트 리소스를 변경할 수 있습니다.
                </p>
                @livewire('site-session-slot')
            </div>
        </div>

        {{$slot}}
    </div>
</div>

<!-- 페이지 리로드를 위한 JavaScript -->
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var offcanvasElement = document.getElementById('offcanvas-right-site-setting');
        offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
            location.reload();
        });
    });
</script> --}}

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('slot-reload', (event) => {
            console.log("slot-reload");
            //window.history.go(-1);
            location.reload();
        });
    });
</script>
