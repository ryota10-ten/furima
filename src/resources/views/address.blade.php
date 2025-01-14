<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/address.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <img class="header__logo--img" src="{{asset('img/logo.svg')}}" alt="CoachTech">
            </div>
            <form class="header__search" method="get" action="/search">
            @csrf
                <input class="header__search--item" type="text" name="keyword" placeholder="なにをお探しですか？">
            </form>
            <div class="header__buttons">
                <form method="POST" action="/purchase/address/{{ $product['id'] }}">
                @csrf
                    <button class="header__button--logout" type="submit">ログアウト</button>
                </form>
                <a class="header__button--mypage" href="/mypage">マイページ</a>
                <a class="header__button--sell" href="/sell">出品</a>
            </div>
        </div>
    </header>
    <main class="content">
        <h1 class="content__title">住所の変更</h1>
        <div class="content__form">
            <form class="form__update" action="/purchase/address/{{ $product['id'] }}" method="POST" >
            @csrf
                <input class="form__update--item" type="hidden" name="name" value="{{ $user['name'] }}" >
                <label class="form__update--label">郵便番号</label>
                <input class="form__update--item" type="text" name="post" value="{{  old('post', $user['post']) }}">
                <div class="form__error">
                    @error('post')
                    {{ $message }}
                    @enderror
                </div>
                <label class="form__update--label">住所</label>
                <input class="form__update--item" type="text" name="address" value="{{  old('address', $user['address']) }}">
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
                <label class="form__update--label">建物名</label>
                <input class="form__update--item" type="text" name="building" value="{{  old('building', $user['building']) }}">
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
                <button class="form__update--button" type="submit">更新する</button>
            </form>
        <div>
    </main>
</body>
</html>