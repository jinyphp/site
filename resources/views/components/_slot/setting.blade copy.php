<!-- 추가적인 CSS -->
<style>
    #floatingButtons {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000; /* 다른 요소 위에 표시되도록 설정 */
    }
    .floating-button {
        display: flex;
        justify-content: center;
        align-items: center;

      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #3B7DDD; /* 버튼의 배경색 설정 */
      color: #fff; /* 버튼 텍스트 색상 설정 */
      text-align: center;
      line-height: 40px; /* 버튼 내 텍스트를 세로 중앙 정렬하기 위해 */
      font-size: 24px; /* 버튼 내 텍스트 크기 설정 */
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* 그림자 효과 추가 */
      cursor: pointer; /* 포인터 커서로 변경 */
    }
</style>

<div id="floatingButtons">
    <!-- 동그란 버튼 추가 -->
    <button class="floating-button" type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvas-right-site-setting"
    aria-controls="offcanvas-right-site-setting">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders2-vertical" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 10.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1H3V1.5a.5.5 0 0 0-1 0V10H.5a.5.5 0 0 0-.5.5M2.5 12a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5m3-6.5A.5.5 0 0 0 6 6h1.5v8.5a.5.5 0 0 0 1 0V6H10a.5.5 0 0 0 0-1H6a.5.5 0 0 0-.5.5M8 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2A.5.5 0 0 0 8 1m3 9.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1H14V1.5a.5.5 0 0 0-1 0V10h-1.5a.5.5 0 0 0-.5.5m2.5 1.5a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5"/>
        </svg>
    </button>
</div>

<div class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvas-right-site-setting"
    aria-labelledby="offcanvas-right-site-setting">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Site Design Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var offcanvasElement = document.getElementById('offcanvas-right-site-setting');
        offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
            location.reload();
        });
    });
</script>
