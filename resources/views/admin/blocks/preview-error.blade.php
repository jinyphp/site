<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Error - {{ $filename }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fa;
        }

        .error-header {
            background: #dc3545;
            color: white;
            padding: 15px 20px;
            border-bottom: 1px solid #c82333;
        }

        .error-content {
            padding: 30px 20px;
        }

        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 14px;
            line-height: 1.5;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
        }

        .line-numbers {
            color: #718096;
            margin-right: 20px;
            user-select: none;
        }
    </style>
</head>
<body>
    <!-- 에러 헤더 -->
    <div class="error-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3"></i>
            <div>
                <h5 class="mb-1">블록 미리보기 오류</h5>
                <small>{{ $filename }}.blade.php</small>
            </div>
        </div>
    </div>

    <!-- 에러 내용 -->
    <div class="error-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- 에러 메시지 -->
                    <div class="text-center mb-5">
                        <div class="error-icon">
                            <i class="fas fa-bug"></i>
                        </div>
                        <h2 class="text-danger mb-3">미리보기 생성 실패</h2>
                        <p class="text-muted mb-4">
                            블록을 렌더링하는 중에 오류가 발생했습니다.<br>
                            아래의 오류 메시지를 확인하고 코드를 수정해주세요.
                        </p>
                    </div>

                    <!-- 에러 상세 -->
                    <div class="card border-danger mb-4">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                오류 메시지
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger mb-0">
                                <pre class="mb-0">{{ $error }}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- 원본 코드 -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-code me-2"></i>
                                    원본 소스코드
                                </h6>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyCode()">
                                    <i class="fas fa-copy me-1"></i>
                                    복사
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="code-block" id="sourceCode">{{ $original_content }}</div>
                        </div>
                    </div>

                    <!-- 도움말 -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        일반적인 오류 원인
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="small mb-0">
                                        <li>닫히지 않은 HTML 태그</li>
                                        <li>잘못된 Blade 문법</li>
                                        <li>존재하지 않는 변수 참조</li>
                                        <li>문법 오류 (예: 따옴표 불일치)</li>
                                        <li>잘못된 PHP 문법</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-tools me-2"></i>
                                        해결 방법
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="small mb-0">
                                        <li>HTML 태그가 올바르게 닫혔는지 확인</li>
                                        <li>Blade 문법이 정확한지 검사</li>
                                        <li>변수명 오타 확인</li>
                                        <li>따옴표와 괄호의 짝 맞춤</li>
                                        <li>PHP 문법 검증</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 액션 버튼 -->
                    <div class="text-center mt-4">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>
                            돌아가기
                        </a>
                        <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                            <i class="fas fa-sync me-1"></i>
                            다시 시도
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 코드 복사 기능
        function copyCode() {
            const codeElement = document.getElementById('sourceCode');
            const text = codeElement.textContent;

            navigator.clipboard.writeText(text).then(function() {
                // 버튼 텍스트 변경으로 피드백
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-1"></i>복사됨';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-secondary');

                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            }).catch(function() {
                alert('복사에 실패했습니다.');
            });
        }

        // 에러 정보를 부모 창에 전달 (iframe인 경우)
        if (window.parent && window.parent !== window) {
            window.parent.postMessage({
                type: 'preview-error',
                error: '{{ addslashes($error) }}',
                filename: '{{ $filename }}'
            }, '*');
        }
    </script>
</body>
</html>