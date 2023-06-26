<header class="header-after-login gray-header">
        <div class="logoNavbar">
            <a href="{{ route('home'); }}" class="logo-a">
                <img src="{{asset('/assets/images/logo/Logo.png')}}" alt=".." class="logo" />
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            <a href="{{ route('my-rewards'); }}" class="reward-box">
                <img src="{{asset('/assets/images/structure/stars-circle.svg')}}" alt=".." class="icon24" />
                <span>{{ auth()->user()->total_rewards_points }}</span>
            </a>
            <div class="dropdown">
            <button class="dropdown-toggle" type="button" id="afterLoginMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{asset('/assets/images/structure/profile_default.png')}}" alt=".." class="icon36round" id="header_pp_icon" />
            <span class="text-capitalize" id="full_name_txt3">{{ auth()->user()->full_name }}</span>
          </button>
               <ul class="dropdown-menu" aria-labelledby="afterLoginMenu">
                @if (auth()->user()->access == 'customer')
                <li>
                    <a class="dropdown-item" href="{{ route('my-bookings'); }}">
                        <img src="{{asset('/assets/images/structure/my-bookings.svg')}}" alt=".." class="icon24" />
                        <span>{{ __('home.myBookings') }}</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('my_profile') }}">
                        <img src="{{asset('/assets/images/structure/account-icon.svg')}}" alt=".." class="icon24" />
                        <span>{{ __('home.myProfile') }}</span>
                    </a>
                </li>
                @elseif (auth()->user()->access == 'hotel_manager' || auth()->user()->access == 'hotel_staff' || auth()->user()->access == 'admin' )
                <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        <img src="{{asset('/assets/images/structure/dashboard-icon.svg')}}" alt=".." class="icon24" />
                        <span>{{ __('home.dashboard') }}</span>
                    </a>
                </li>
                @endif
                <li>
                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target=".changePassword">
                        <img src="{{asset('/assets/images/structure/lock-icon.svg')}}" alt=".." class="icon24" />
                        <span>{{ __('home.changePassword') }}</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <img src="{{asset('/assets/images/structure/logout-icon.svg')}}" alt=".." class="icon24" />
                        <span>{{ __('home.logout') }}</span>
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </header>