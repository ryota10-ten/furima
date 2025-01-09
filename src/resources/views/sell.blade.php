<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/sell.css')}}">
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
        <h1 class="content__title">商品の出品</h1>
        <div class="form">
            <form class="form__sell" action="/sell" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form__sell--item">
                    <h3 class="form__item--title">商品画像</h3>
                    <div class="form__update--preview" id="img-preview">
                        <label class="form__update--item" for="img">
                            画像を選択する
                        </label>
                    </div>
                    <input class="form__update--img" type="file" id="img" name="img" accept=".jpeg, .png, .jpg" >
                    <div class="form__error">
                        @error('img')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <h2 class="form__sell--title">商品の説明</h2>
                <div class="form__sell---item">
                    <h3 class="form__item--title">カテゴリー</h3>
                    <div class="form__category">
                    @foreach ($categories as $category)
                        <input class="form__category--item" type="checkbox" name="category[]" id="category-{{ $category['id'] }}" value="{{ $category['id'] }}">
                        <label class="category__label" for="category-{{ $category['id'] }}">
                        {{ $category['category'] }}
                        </label>
                    @endforeach
                    </div>
                    <div class="form__error">
                        @error('category')
                        {{ $message }}
                        @enderror
                    </div>
                    <h3 class="form__item--title">商品の状態</h3>
                    <div class="form__condition">
                        <select class="form__condition--item" name="condition_id">
                            <option value="" selected>選択してください</option>
                            @foreach ($conditions as $condition)
                            <option value="{{ $condition['id'] }}">
                                <label class="condition__label" for="condition-{{ $condition['id'] }}">
                                {{ $condition['condition'] }}
                                </label>
                            </option>
                        @endforeach
                        </select>
                        <div class="form__error">
                        @error('condition_id')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </div>
                <h2 class="form__sell--title">商品名と説明</h2>
                <div class="form__sell---item">
                    <h3 class="form__item--title">商品名</h3>
                    <input class="form__item" type="text" name="name" value="{{ old('name') }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                    <h3 class="form__item--title">商品の説明</h3>
                    <textarea class="form__item" name="detail" rows="10" value="{{ old('detail') }}"></textarea>
                    <div class="form__error">
                        @error('detail')
                        {{ $message }}
                        @enderror
                    </div>
                    <h3 class="form__item--title">販売価格</h3>
                    <input class="form__item" type="text" name="price" value="&yen;">
                    <div class="form__error">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <button class="form__button" type="submit">
                    出品する
                </button>
            </form>
        </div>
        <script>
            const fileInput = document.getElementById('img');
            const imagePreview = document.getElementById('img-preview');

            // ファイル選択イベント
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                imagePreview.innerHTML = '';
                imagePreview.style.backgroundColor = '#D9D9D9';

                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        imagePreview.appendChild(img);
                        imagePreview.style.backgroundColor = 'transparent'; // 背景色を透明に
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </main>
</body>
</html>