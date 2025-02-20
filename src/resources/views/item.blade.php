<!DOCTYPE html>
<html lang="ja">
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
                <a href="/">
                    <img class="header__logo--img" src="{{asset('img/logo.svg')}}" alt="CoachTech">
                </a>
            </div>
            <form class="header__search" method="get" action="/search">
            @csrf
                <input class="header__search--item" type="text" name="keyword" placeholder="なにをお探しですか？">
            </form>
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
                    <img class="img" src="{{ asset('storage/' . $product['img']) }}" alt="{{ $product['name'] }}">
                </div>
            </div>
            <div class="item__detail">
                <p class="item__detail--name">{{ $product['name'] }}</p>
                <p class="item__detail--brand">{{ $product['brand'] }}</p>
                <p class="item__detail--price">
                    &yen;<span class="price">{{ number_format($product['price']) }}</span>円（税込）
                </p>
                @if ($product->orders->isNotEmpty())
                <p class="product__sold">
                    SOLD
                </p>
                @endif
                <div class=review>
                    <div class="review__like">
                        <form class="form__review" method="post" action="/item/{{ $product['id'] }}/like">
                        @csrf
                            <input class="review__favorite" id="favorite-{{ $product['id'] }}" type="checkbox" name="favorite" {{ $product->isLikedBy(Auth::id()) ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="favorite-{{ $product['id'] }}">
                                <span class="review__icon">
                                    ★
                                </span>
                            </label>
                        </form>
                        <div class="favorites_count">
                            {{ $favoriteCount }}
                        </div>
                    </div>
                    <div class="review__comment">
                        <svg xmlns='http://www.w3.org/2000/svg' height='50' width='50' viewBox='0 0 190 170' style='fill:#ffffff;stroke:#000000' >
                            <path d='M100,150 A80,70 0 1 0 80,150 L105,170 L100,150 Z'>
                            </path>
                        </svg>
                        <div class="comments_count">
                            {{ $commentCount }}
                        </div>
                    </div>
                </div>
                <form class="item__purchase" action="/purchase/{{ $product['id'] }}" method="post">
                @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <button class="button__purchase" type="submit">
                        購入手続きへ
                    </button>
                </form>
                <h2 class="item__detail--explain">商品説明</h2>
                <p class="item__detail--explain">
                    {{ $product['detail'] }}
                </p>
                <h2 class="item__info">商品の情報</h2>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">カテゴリー</span>
                    </div>
                    <div class="detail__info">
                        @foreach ($categories as $category)
                        <div class="detail__info--category">{{ $category['category']}}</div>
                        @endforeach
                    </div>
                </div>
                <div class="info__detail">
                    <div class="detail__header">
                        <span class="detail__header--title">商品の状態</span>
                    </div>
                    <div class="detail__info">
                        <div class="detail__info--condition">{{  $condition['condition'] }}</div>
                    </div>
                </div>
                <h2 class="item__comment">コメント（{{ $commentCount }}）</h2>
                @foreach ($product->comments as $comment)
                    <div class="profile__data">
                        <div class="profile__data--icon">
                            @if (!empty($comment['user']['icon']))
                            <img src="{{ asset('storage/' . $comment['user']['icon']) }}" alt="ユーザーアイコン" >
                            @else
                            <img src="{{ asset('img/default-icon.png') }}" >
                            @endif
                        </div>
                        <div class="profile__data--name">
                            {{ $comment['user']['name'] }}
                        </div>
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
                    <textarea class="input__comment" name="comment" placeholder="コメントを入力" rows="10" value="{{ old('comment') }}"></textarea>
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