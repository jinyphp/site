<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>지원 요청 답변</title>
    <style>
        body {
            font-family: 'Malgun Gothic', 'Apple SD Gothic Neo', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 30px 20px;
        }
        .support-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .reply-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-resolved { background-color: #d4edda; color: #155724; }
        .status-in-progress { background-color: #d1ecf1; color: #0c5460; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-closed { background-color: #f8d7da; color: #721c24; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 헤더 -->
        <div class="header">
            <h1>지원 요청 답변</h1>
            <p>고객 지원팀에서 답변드립니다</p>
        </div>

        <!-- 본문 -->
        <div class="content">
            <p>안녕하세요, <strong>{{ $customerName }}</strong>님!</p>

            <p>문의해 주신 지원 요청에 대해 답변드립니다.</p>

            <!-- 지원 요청 정보 -->
            <div class="support-info">
                <h3>요청 정보</h3>
                <p><strong>티켓 번호:</strong> #{{ $support->id }}</p>
                <p><strong>제목:</strong> {{ $support->subject }}</p>
                <p><strong>상태:</strong>
                    <span class="status-badge status-{{ $support->status }}">
                        @if($support->status === 'pending')대기중
                        @elseif($support->status === 'in_progress')처리중
                        @elseif($support->status === 'resolved')해결완료
                        @elseif($support->status === 'closed')종료
                        @else{{ $support->status }}@endif
                    </span>
                </p>
                <p><strong>등록일:</strong> {{ $support->created_at ? $support->created_at->format('Y년 m월 d일 H:i') : '' }}</p>
                @if($support->assignedTo)
                <p><strong>담당자:</strong> {{ $support->assignedTo->name }}</p>
                @endif
            </div>

            <!-- 원본 요청 내용 -->
            <div>
                <h3>요청하신 내용</h3>
                <div class="reply-content">
                    {!! nl2br(e($support->content)) !!}
                </div>
            </div>

            <!-- 답변 내용 -->
            <div>
                <h3>답변 내용</h3>
                <div class="reply-content">
                    {!! nl2br(e($adminReply)) !!}
                </div>
            </div>

            @if($support->status === 'resolved')
            <div style="background-color: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p><strong>✅ 해결완료</strong></p>
                <p>요청하신 사항이 해결되었습니다. 추가 문의사항이 있으시면 언제든지 연락주세요.</p>
            </div>
            @endif

            <!-- 추가 문의 안내 -->
            <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 5px;">
                <p><strong>추가 문의가 있으신가요?</strong></p>
                <p>이 답변에 대해 추가 질문이나 도움이 필요하시면 이 이메일에 직접 답장하시거나 고객지원 센터를 통해 문의해 주세요.</p>

                <!-- 웹사이트 링크 (실제 환경에 맞게 수정) -->
                <a href="{{ config('app.url') }}" class="btn">웹사이트 방문하기</a>
            </div>
        </div>

        <!-- 푸터 -->
        <div class="footer">
            <p>이 이메일은 자동으로 발송된 메일입니다.</p>
            <p>{{ config('app.name', 'Jiny Site') }} 고객지원팀</p>
            <p>{{ config('app.url') }}</p>

            <div style="margin-top: 15px; font-size: 10px;">
                <p>본 메일은 {{ now()->format('Y년 m월 d일 H:i:s') }}에 발송되었습니다.</p>
            </div>
        </div>
    </div>
</body>
</html>