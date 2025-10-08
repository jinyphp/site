<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>사이트 유지보수 중</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        h1 {
            color: #667eea;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 사이트 유지보수 중</h1>
        <p>{{ $message ?? '현재 사이트 유지보수 작업이 진행 중입니다. 잠시 후 다시 방문해 주세요.' }}</p>
    </div>
</body>
</html>
