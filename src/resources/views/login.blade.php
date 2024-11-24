<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CouchTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img class="header__logo" src="{{asset('img/logo.svg')}}" alt="CouchTech">
        </div>
    </div>
    <main class="content">
        <h1 class="content__title">
            ログイン
        </h1>
        <div class="content__form">
            <form class="form__login" action="/login" method="post">
                <label class="form__login--label">ユーザー名 / メールアドレス</label>
                <input class="form__login--item" type="text" name="name" value="" require>
                <label class="form__login--label">パスワード</label>
                <input class="form__login--item" type="password" name="password" value="" require>
                <button class="form__login--button" type="submit">ログインする</button>
            </form>
        </div>
        <div class="content__register">
            <a class="content__register--item" href="/register">会員登録はこちら</a>
        </div>

    </main>
</body>
</html>