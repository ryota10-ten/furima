<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
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
                <input type="hidden" name="tab" id="search_tab" value="{{ $tab ?? 'tab1' }}">
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
        <div class="tab_wrap">
            <input id="tab1" type="radio" name="tab_btn" {{ ($tab ?? 'tab1') === 'tab1' ? 'checked' : '' }}>
            <input id="tab2" type="radio" name="tab_btn" {{ ($tab ?? 'tab1') === 'tab2' ? 'checked' : '' }}>

            <div class="tab_area">
                <label class="tab1_label" for="tab1">おすすめ</label>
                <label class="tab2_label" for="tab2">マイリスト</label>
            </div>
            <div class="panel_area">
                <div id="panel1" class="product__list">
                    @foreach ($products as $product)
                    <div class="product__item">
                        <a class="product__link" href="/item/{{ $product['id'] }}">
                            <div class="product__img">
                                <img class="img" src="{{ asset('storage/' . $product['img']) }}" alt="{{ $product['name'] }}">
                            </div>
                            <div class="product__name">
                            {{ $product['name'] }}
                            @if ($product->orders->isNotEmpty())
                            <div class="product__sold">SOLD</div>
                            @endif
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div id="panel2" class="product__list">
                    @if (Auth::check())
                        @foreach ($favorites as $product)
                        <div class="product__item">
                            <a class="product__link" href="/item/{{ $product['id'] }}">
                                <div class="product__img">
                                    <img class="img" src="{{ asset('storage/' . $product['img']) }}" alt="{{ $product['name'] }}">
                                </div>
                                <div class="product__name">
                                {{ $product['name'] }}
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <p>ログインしてください</p>
                    @endif
                </div>
            </div>
        </div>
        <script>
            const tab1 = document.getElementById('tab1');
            const tab2 = document.getElementById('tab2');
            const searchTab = document.getElementById('search_tab');

            tab1.addEventListener('change', () => { searchTab.value = 'tab1'; });
            tab2.addEventListener('change', () => { searchTab.value = 'tab2'; });
        </script>
    </main>
</body>
</html>