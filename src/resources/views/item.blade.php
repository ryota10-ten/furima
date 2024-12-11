<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/item.css')}}">
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
            <div class="header__search">
                <input class="header__search--item" type="text" placeholder="なにをお探しですか？">
            </div>
            <div class="header__buttons">
                @if (Auth::check())
                <form method="POST" action="/logout">
                @csrf
                    <button class="header__button--logout" type="submit">ログアウト</button>
                </form>
                @else
                <a class="header__button--login" href="/login">ログイン</a>
                @endif
                <a class="header__button--mypage" href="/mypage">マイページ</a>
                <a class="header__button--sell" href="/sell">出品</a>
            </div>
        </div>
    </header>
    <main class="content">
        <div class="content-item">
            <div class="item__detail">
                <div class="item__detail--img">
                商品画像
                </div>
            </div>
            <div class="item__detail">
                <form class="item__purchase">
                    <input type="hidden" name="">
                    <p class="item__detail--name">商品名がここに入る</p>
                    <p class="item__detail--brand">ブランド名</p>
                    <p class="item__detail--price">¥4,700円</p>
                    <button class="button__purchase" type="submit">購入手続きへ</button>
                </form>
                <h2 class="item__detail--explain">商品説明</h2>
                <h2 class="item__info">商品の情報</h2>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">カテゴリー</span>
                    </div>
                    <div class="detail__info">
                        <div class="detail__info--category">洋服</div>
                        <div class="detail__info--category">メンズ</div>
                    </div>
                </div>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">商品の状態</span>
                    </div>
                    <div class="detail__info">
                        <div class="detail__info--condition">良好</div>
                    </div>
                </div>
                <h2 class="item__comment">コメント（1）</h2>
                <div class="profile__data">
                    <div class="profile__data--icon"></div>
                    <div class="profile__data--name">admin</div>
                </div>
                <div class="profile__comment">
                    こちらにコメントが入ります。
                </div>
                <div class="form__comment--title">
                    商品へのコメント
                </div>
                <form class="form__comment">
                    <input type="hidden" name="id">
                    <textarea class="input__comment" type="text" name="comment">
                    </textarea>
                    <button class="button__comment" type="submit">
                        コメントを送信する
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>