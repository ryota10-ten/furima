<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/purchase.css')}}">
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
        <div class="content__purchase">
            <div class="purchase__info">
                <div class="item__info">
                    <div class="item__info--img">
                        <img class="item__img" src="{{ asset('storage/' . $product['img']) }}" alt="{{ $product['name'] }}">
                    </div>
                    <div class="item__info--detail">
                        <p class="item__name">
                            {{ $product['name'] }}
                        </p>
                        <p class="item__price">
                            <span>
                                &yen;
                            </span>
                            {{ number_format($product['price']) }}
                        </p>
                    </div>
                </div>
                <div class="purchase__method">
                    <h3 class="purchase__method--header">
                        支払い方法
                    </h3>
                    <form method="POST" action="/purchase/method/{{ $product['id'] }}">
                    @csrf
                        <select class="purchase__method--select" name="method" onchange="this.form.submit()">
                            <option value="" {{ $selectedMethod == '' ? 'selected' : '' }}>
                                選択してください
                            </option>
                            <option value="コンビニ払い" {{ $selectedMethod == 'コンビニ払い' ? 'selected' : '' }}>
                                コンビニ払い
                            </option>
                            <option value="カード払い" {{ $selectedMethod == 'カード払い' ? 'selected' : '' }}>
                                カード払い
                            </option>
                        </select>
                    </form>
                </div>
                <div class="purchase__address">
                    <div class="address__navi">
                        <h3 class="address__header">
                            配送先
                        </h3>
                        <p class="address__edit">
                            <a href="/purchase/address/{{ $product['id'] }}">変更する</a>
                        </p>
                    </div>
                    <div class="address__info">
                        @if(empty($address))
                            〒{{ $user['post'] }}<br>
                            {{ $user['address'] }}{{ $user['building'] }}
                        @else
                            〒{{ $address['post'] }}<br>
                            {{ $address['address'] }}{{ $address['building'] }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="purchase__form">
                <form class="form" action="{{ route('purchase.fix', ['id' => $product->id]) }}" method="post" >
                @csrf
                    <table class="form__table">
                        <tr class="form__table--row">
                            <th class="form__table--header">
                                商品代金
                            </th>
                            <td class="form__table--item">
                                <span class="price__font">&yen;</span>{{ number_format($product['price']) }}
                            </td>
                        </tr>
                        <tr class="form__table--row">
                            <th class="form__table--header">
                                支払い方法
                            </th>
                            <td class="form__table--item">
                                <input type="text" name="method" value="{{ $selectedMethod ?? '選択してください' }}" readonly/>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if(is_null($address))
                    <input type="hidden" name="post" value="{{ $user['post'] }}">
                    <input type="hidden" name="address" value="{{ $user['address'] }}">
                    <input type="hidden" name="building" value="{{ $user['building'] }}">
                    @else
                    <input type="hidden" name="post" value="{{ $address['post'] }}">
                    <input type="hidden" name="address" value="{{ $address['address'] }}">
                    <input type="hidden" name="building" value="{{ $address['building'] }}">
                    @endif
                    <div class="form__error">
                        @error('method')
                        {{ $message }}
                        @enderror
                    </div>
                    <button class="button__purchase" type="submit">
                        購入する
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>