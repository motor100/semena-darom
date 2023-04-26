<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  @yield('style')
  <link rel="stylesheet" href="{{ asset('/adminpanel/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminpanel/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminpanel/css/template.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminpanel/css/dashboard.css') }}">
</head>
<body>
  <div class="wrapper">

    <aside class="aside">

      <div class="aside-header">
        <div class="logo">
          <!-- <img src="" alt=""> -->
          <span>{{ config('app.name') }}</span>
        </div>
      </div>

      <div class="aside-content">
        <div class="aside-nav">

          <div class="nav-item">
            <a href="/dashboard/clients" class="item-link">
              <i class="nav-icon fas fa-users"></i>
              <span>Клиенты</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="/dashboard/events" class="item-link">
              <i class="nav-icon fas fa-car-side"></i>
              <span>События</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="/dashboard/notifications" class="item-link">
              <i class="nav-icon fas fa-bell"></i>
              <span>Уведомления</span>
            </a>
          </div>

          <div class="nav-item">
            <a href="" class="item-link">
              <i class="nav-icon fas fa-bell"></i>
              <span>Страницы</span>
            </a>
            <ul class="nav nav-treeview">
              <li>
                <a href="/dashboard/polzovatelskoe-soglashenie-s-publichnoj-ofertoj" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Пользовательское соглашение с публичной офертой</p>
                </a>
              </li>
              <li>
                <a href="/dashboard/politika-konfidencialnosti" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Политика конфиденциальности</p>
                </a>
              </li>
              <li>
                <a href="/dashboard/garantiya-vozvrata-denezhnyh-sredstv" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Гарантия возврата денежных средств</p>
                </a>
              </li>
            </ul>
          </div>
          
        </div>
      </div>
      
    </aside>

    <div class="content-wrapper">
      <div class="content-header navbar-expand display-flex justify-content-spacebetween">

        <div class="header-nav display-flex flexdirection-row alignitems-center">
          <div class="nav-item">
            <div class="burger">
              <a href="#" class="header-item display-block">
                <i class="fas fa-bars"></i>
              </a>
            </div>
          </div>
          <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="header-item display-block">Главная</a>
          </div>
        </div>

        <div class="header-nav display-flex flexdirection-row alignitems-center">
          <!-- 
          <div class="nav-item">
            
            <a href="#" class="header-item">
              <a href="#" class="header-item"></a>
              <i class="far fa-comments"></i>
            </a>
            
          </div>
           -->
          <div class="nav-item">
            <a href="#" class="header-item display-block pos-relative">
              <i class="far fa-bell"></i>

              @if(isset($notifications_count))
                @if($notifications_count > 0)
                  <span id="notifications-counter" class="tp-badge tp-badge-warning">{{ $notifications_count }}</span>
                @endif
              @endif

            </a>
          </div>
          <div class="nav-item">
            <div class="user display-flex header-item">
              <div class="user-image">
                <i class="far fa-user"></i>
              </div>
              <div class="user-name">{{ Auth::user()->name }}</div>
            </div>
          </div>
        </div>

      </div>

      <div class="content">

        <div class="content-title">@yield('title')</div>

        @yield('dashboardcontent')

        <div class="user-menu">
          <div class="menu-item">
            <a href="{{ route('profile.edit') }}" class="item-link">Профиль</a>
          </div>
          <div class="menu-item">
            <form action="{{ route('logout') }}" class="form" method="POST">
              @csrf
              <button class="logout-btn">Выйти</button>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>

  @yield('script')
  <script src="{{ asset('/adminpanel/js/template.js') }}"></script>
  <script src="{{ asset('/adminpanel/js/dashboard.js') }}"></script>

</body>
</html>