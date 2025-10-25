<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Block Preview - {{ $filename }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- 추가 스타일 -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .preview-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 15px;
            font-size: 12px;
            color: #6c757d;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .preview-content {
            background: #fff;
        }

        /* 미리보기용 기본 스타일 */
        img {
            max-width: 100%;
            height: auto;
        }

        .btn {
            cursor: pointer;
        }

        /* 플레이스홀더 이미지 스타일 */
        .placeholder-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- 미리보기 헤더 -->
    <div class="preview-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-eye me-1"></i>
                <strong>{{ $filename }}.blade.php</strong> 미리보기
            </div>
            <div>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    {{ date('Y-m-d H:i:s') }}
                </small>
            </div>
        </div>
    </div>

    <!-- 실제 블록 내용 -->
    <div class="preview-content">
        {!! $content !!}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 미리보기용 스크립트 -->
    <script>
        // 모든 링크를 비활성화 (미리보기 목적)
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a');
            links.forEach(function(link) {
                if (link.getAttribute('href') === '#' || link.getAttribute('href') === '') {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        // 클릭 효과 표시
                        const originalBg = link.style.backgroundColor;
                        link.style.backgroundColor = '#007bff';
                        link.style.color = 'white';

                        setTimeout(function() {
                            link.style.backgroundColor = originalBg;
                            link.style.color = '';
                        }, 200);
                    });
                }
            });

            // 폼 제출 방지
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('이것은 미리보기입니다. 실제 제출은 되지 않습니다.');
                });
            });

            // 이미지 에러 처리
            const images = document.querySelectorAll('img');
            images.forEach(function(img) {
                img.addEventListener('error', function() {
                    // 플레이스홀더로 교체
                    const placeholder = document.createElement('div');
                    placeholder.className = 'placeholder-image';
                    placeholder.innerHTML = '<span><i class="fas fa-image me-2"></i>이미지 로드 실패</span>';
                    placeholder.style.width = img.width || '300px';
                    placeholder.style.height = img.height || '200px';

                    img.parentNode.replaceChild(placeholder, img);
                });
            });

            // 부모 창에 높이 전달 (iframe인 경우)
            function notifyHeightChange() {
                const height = document.body.scrollHeight;
                if (window.parent && window.parent !== window) {
                    window.parent.postMessage({
                        type: 'resize',
                        height: height
                    }, '*');
                }
            }

            // 초기 높이 전달
            setTimeout(notifyHeightChange, 100);

            // 이미지 로드 완료 후 높이 재계산
            Promise.all(Array.from(images).map(img => {
                if (img.complete) return Promise.resolve();
                return new Promise(resolve => {
                    img.onload = resolve;
                    img.onerror = resolve;
                });
            })).then(notifyHeightChange);
        });

        // 개발자 도구 열기 방지 (미리보기 환경)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
                return false;
            }
        });

        // 우클릭 방지 (미리보기 환경)
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
    </script>
</body>
</html>