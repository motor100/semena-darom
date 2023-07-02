<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Личный кабинет')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('/img/favicon.svg') }}" type="image/x-icon">
  @yield('style')

</head>
<body>
  <div class="wrapper">

    @yield('lkcontent')

    <div class="user-name">{{ Auth::user()->name }}</div>

    <div class="menu-item">
      <form action="{{ route('logout') }}" class="form" method="POST">
        @csrf
        <button class="logout-btn">Выйти</button>
      </form>
    </div>

  </div>

  @yield('script')


</body>
</html>