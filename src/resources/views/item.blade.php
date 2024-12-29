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
                    <img class="img" src="{{ $product['img']}}" alt="{{ $product['name'] }}">
                </div>
            </div>
            <div class="item__detail">
                <form class="item__purchase">
                    <input type="hidden" name="">
                    <p class="item__detail--name">{{ $product['name'] }}</p>
                    <p class="item__detail--brand"></p>
                    <p class="item__detail--price">¥{{ number_format($product['price']) }}円</p>
                    <button class="button__purchase" type="submit">購入手続きへ</button>
                </form>
                <h2 class="item__detail--explain">商品説明</h2>
                    <p class="item__detail--explain">{{ $product['detail'] }}
                <h2 class="item__info">商品の情報</h2>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">カテゴリー</span>
                    </div>
                    <div class="detail__info">
                        @foreach($product->categories as $category)
                        <div class="detail__info--category">{{ $category['category']}}</div>
                        @endforeach
                    </div>
                </div>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">商品の状態</span>
                    </div>
                    <div class="detail__info">
                        <div class="detail__info--condition">{{  $product['condition']['condition'] }}</div>
                    </div>
                </div>
                <h2 class="item__comment">コメント（{{ $question['comments_count'] }}）</h2>
                @foreach ($question->comments as $comment)
                    <div class="profile__data">
                        
                        <div class="profile__data--name">{{ $comment['profile']['name'] }}</div>
                    </div>
                    <div class="profile__comment">
                        {{ $comment['comment'] }}
                    </div>
                @endforeach
                <div class="form__comment--title">
                    商品へのコメント
                </div>
                <form class="form__comment" action="/comments" method="POST">
                @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea class="input__comment" name="comment" placeholder="コメントを入力"></textarea>
                    <div class="form__error">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </div>
                    <button class="button__comment" type="submit">
                        コメントを送信する
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>