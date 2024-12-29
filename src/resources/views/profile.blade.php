<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
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
                <form method="POST" action="">
                @csrf
                    <button class="header__button--logout" type="submit">ログアウト</button>
                </form>
                <a class="header__button--mypage" href="/mypage">マイページ</a>
                <a class="header__button--sell" href="/sell">出品</a>
            </div>
        </div>
    </header>
    <main class="content">
        <h1 class="content__title">プロフィールの設定</h1>
        <div class="content__form">
            <form class="form__update" action="/" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form__icon">
                    <div class="form__update--preview" id="icon-preview">
                        @if (!empty($profile['icon']))
                        <img src="{{ asset('storage/' . $profile['icon']) }}" alt="現在のアイコン">
                        @else
                        <img src="{{ asset('img/default-icon.png') }}" style="width: 100px; height: 100px; border-radius: 50%;">
                        @endif
                    </div>
                    <label class="form__update--icon" for="icon">画像を選択する
                    </label>
                    <input class="form__update--img" type="file" id="icon" name="icon" accept=".jpeg, .png, .jpg" >
                </div>
                <div class="form__error">
                    @error('icon')
                    {{ $message }}
                    @enderror
                </div>
                <input type="hidden" name="email" value="{{ $profile['email'] }}" >
                <input type="hidden" name="password" value="{{ $profile['password'] }}" >
                <label class="form__update--label">名前</label>
                <input class="form__update--item" type="text" name="name" value="{{ $profile['name'] }}" >
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
                <label class="form__update--label">郵便番号</label>
                <input class="form__update--item" type="text" name="post" value="{{  old('post', optional($profile)->post) }}">
                <div class="form__error">
                    @error('post')
                    {{ $message }}
                    @enderror
                </div>
                <label class="form__update--label">住所</label>
                <input class="form__update--item" type="text" name="address" value="{{  old('address', optional($profile)->address)}}">
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
                <label class="form__update--label">建物名</label>
                <input class="form__update--item" type="text" name="building" value="{{  old('building', optional($profile)->building)}}">
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
                <button class="form__update--button" type="submit">更新する</button>
            </form>
        <div>
        <script>
            const fileInput = document.getElementById('icon');
            const imagePreview = document.getElementById('icon-preview');

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