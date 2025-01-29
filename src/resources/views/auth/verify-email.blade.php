<!DOCTYPE html>
<html>
<head>
    <title>メール認証が必要です</title>
</head>
<body>
    <h1>メール認証が必要です</h1>
    <p>認証メールが送信されました。メール内のリンクをクリックして認証を完了してください。</p>

    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証メールを再送信する</button>
    </form>
</body>
</html>