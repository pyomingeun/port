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
  <div class="dropdown">
    <button class="dropdown-toggle" type="button" id="onboardingMenu" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="{{ asset('/assets/images/structure/user-icon.svg') }}" alt=".." class="icon28round" />
      <img src="{{ asset('/assets/images/structure/menu-icon.svg') }}" alt=".." class="icon16" />
    </button>
    @auth()
      <ul class="dropdown-menu" aria-labelledby="afterLoginMenu">
        @if (auth()->user()->access == 'customer')
          <li>
            <a class="dropdown-item" href="{{ route('my-bookings') }}">
              <img src="{{ asset('/assets/images/structure/my-bookings.svg') }}" alt=".." class="icon24" />
              <span>{{ __('home.MyBookings') }}</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('my_profile') }}">
              <img src="{{ asset('/assets/images/structure/account-icon.svg') }}" alt=".." class="icon24" />
              <span>{{ __('home.MyProfile') }}</span>
            </a>
          </li>
        @elseif (auth()->user()->access == 'hotel_manager' ||
                auth()->user()->access == 'hotel_staff' ||
                auth()->user()->access == 'admin')
          <li>
            <a class="dropdown-item" href="{{ route('dashboard') }}">
              <img src="{{ asset('/assets/images/structure/dashboard-icon.svg') }}" alt=".." class="icon24" />
              <span>{{ __('home.Dashboard') }}</span>
            </a>
          </li>
        @endif
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
        <li>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <img src="{{ asset('/assets/images/structure/logout-icon.svg') }}" alt=".." class="icon24" />
            <span>{{ __('home.LogOut') }}</span>
          </a>
        </li>
      </ul>
    @endauth
    @guest
      <ul class="dropdown-menu" aria-labelledby="onboardingMenu">
        <li><a class="dropdown-item" href="{{ route('signup') }}">{{ __('home.SignUp') }}</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".loginDialog">{{ __('home.LogIn') }}</a></li>
        <li>
          <hr class="dropdown-divider my-1">
        </li>
        <!-- <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".loginDialog">Manager/ Staff </a></li> -->
        <!-- <li>
                                  <hr class="dropdown-divider my-1">
                              </li> -->
        <!-- <li><a class="dropdown-item" href="#">Dashboard </a></li> -->
        <!-- <li>
                                  <hr class="dropdown-divider my-1">
                              </li> -->
        <!-- <li><a class="dropdown-item" href="#" >Manager/ Staff</a></li>
                              <li>
                                  <hr class="dropdown-divider my-1">
                              </li> -->
        <li><a class="dropdown-item" href="#">{{ __('home.Help') }}</a></li>
        <li><a class="dropdown-item" href="#">{{ __('home.Policies') }}</a></li>
        @if (App::getLocale() == 'en')
          <li><a class="dropdown-item" href="{{ route('change-language', 'ko') }}">Change to Korean </a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('change-language', 'en') }}">Change to English</a></li>
        @endif
      </ul>
    @endguest
  </div>
</header>
