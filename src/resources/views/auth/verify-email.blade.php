<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/verify-email.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/">
                <img class="header__logo--img" src="{{asset('img/logo.svg')}}" alt="CoachTech">
            </a>
        </div>
    </header>
    <main class="content">
        <p class="content__span">
            登録していただいたメールアドレスに認証メールを送付しました。
        </p>
        <p class="content__span">
            メール認証を完了してください。
        </p>
        @if (session('message'))
            <p style="color: green;">{{ session('message') }}</p>
        @endif
        <div class="content__form">
            <form class="form__send" method="POST" action="{{ route('verification.send') }}">
            @csrf
                <button class="form__button" type="submit">認証メールを再送信する</button>
            </form>
        </div>
    </main>
</body>
</html>