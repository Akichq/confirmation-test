<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FashionablyLate')</title>

    <!-- 共通 CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- ページ固有の CSS -->
    @yield('css')

    <!-- jQuery (モーダルなどで使用) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     @yield('js') {{-- section('js')の内容を表示 --}}
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="header-inner">
                <h1 class="header-logo">
                    <a href="/">FashionablyLate</a>
                </h1>
                <nav class="header-nav">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-button">logout</button>
                        </form>
                    @else
                        {{-- 現在のルートによって表示を切り替え --}}
                        @if (request()->routeIs('login'))
                            <a href="{{ route('register') }}" class="nav-button">register</a>
                        @elseif (request()->routeIs('register'))
                            <a href="{{ route('login') }}" class="nav-button">login</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <main class="main">
           @if (session('message'))
                <div class="flash-message">
                    {{ session('message') }}
               </div>
           @endif
            @yield('content')
        </main>

        <footer class="footer">
            {{-- フッターの内容 (必要に応じて) --}}
        </footer>
    </div>

    {{-- ページ固有の JavaScript --}}
    @yield('scripts')
</body>
</html>