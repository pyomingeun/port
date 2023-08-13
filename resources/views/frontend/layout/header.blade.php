<header class="header homeHeader">
  <div class="logoNavbar">
    @if (Request::segment(1) != '')
      <a href="{{ route('home') }}" class="logo-a">
        <img src="{{ asset('/assets/images/logo/Logo.png') }}" alt=".." class="logo" />
      </a>
    @endif
    @if (Request::segment(1) == '')
      <a href="javaScript:Void(0);" class="logo-a">
        <img src="{{ asset('/assets/images/logo/Logo.png') }}" alt=".." class="logo-b" />
      </a>
      <a href="javaScript:Void(0);" class="logo-a">
        <img src="{{ asset('/assets/images/logo/logo-w.png') }}" alt=".." class="logo-w" />
      </a>
    @endif
  </div>
  @auth()
    <div class="dropdown">
      <button class="dropdown-toggle" type="button" id="onboardingMenu" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-bars fa-xl" style="color: #00a99d; margin-right: 10px;"></i> 
          <span style="font-size: 14px; font-family:Pretendard-medium;">MENU</span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="afterLoginMenu">
        @if (auth()->user()->access == 'customer')
          <li>
            <a class="dropdown-item" href="{{ route('my-bookings') }}">
              <i class="fa-regular fa-calendar-check fa-lg" style="color: #00a99d; margin-left: 5px;" >
                <span style="font-size: 14px; color: #000;font-family:Pretendard-light;"> {{ __('home.MyBookings') }}</span>
              </i>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('my_profile') }}">
              <i class="fa-regular fa-id-badge fa-lg" style="color: #00a99d; margin-left: 5px;" >
                <span style="font-size: 14px; color: #000;font-family:Pretendard-light;">{{ __('home.MyProfile') }}</span>
              </i>
            </a>
          </li>
        @elseif (auth()->user()->access == 'hotel_manager' ||
                 auth()->user()->access == 'hotel_staff' ||
                 auth()->user()->access == 'admin')
          <li>
            <a class="dropdown-item" href="{{ route('dashboard') }}">
              <i class="fa-solid fa-chart-line fa-lg" style="color: #00a99d; margin-left: 5px;">
                <span> {{ __('home.Dashboard') }}</span>
              </i>
            </a>
          </li>
        @endif
        <!--
        @if (App::getLocale() == 'en')
          <li><a class="dropdown-item" href="{{ route('change-language', 'ko') }}">Change to Korean </a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('change-language', 'en') }}">Change to English</a></li>
        @endif
        <li>
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".changePassword">
            <img src="{{ asset('/assets/images/structure/lock-icon.svg') }}" alt=".." class="icon24" />
            <span>{{ __('home.ChangePassword') }}</span>
          </a>
        </li>
      -->
        <li>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="color: #00a99d; margin-left: 5px;">
              <span style="font-size: 13px; color: #000; font-family:Pretendard-light;">{{ __('home.LogOut') }}</span>
            </i>
          </a>
        </li>
      </ul>
  @endauth
  @guest
    <div class="logIn" style="margin-right: 30px;">
      <a class="LogInbtn" href="#" data-bs-toggle="modal" data-bs-target=".loginDialog">
        <i class="fa-solid fa-arrow-right-to-bracket fa-xl" style="color: #00a99d;"></i>
        <span style="font-size: 14px; font-family: Pretendard-bold; color: #00a99d"> LOGIN</span>
      </a>

        <!-- @if (App::getLocale() == 'en')
          <li><a class="dropdown-item" href="{{ route('change-language', 'ko') }}">Change to Korean </a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('change-language', 'en') }}">Change to English</a></li>
        @endif -->
      </ul>
  @endguest
    </div>
</header>
