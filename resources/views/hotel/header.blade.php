<header class="header header-after-login gray-header">
        <div class="logoNavbar">
            <a href="{{ route('home') }}" class="logo-a">
                <img src="{{asset('/assets/images/logo/Logo.png')}}" alt=".." class="logo" />
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            @if(auth()->user()->access == 'admin')
                <a href="{{ route('system-configuration-list') }}" class="setting-icon">
                    <img src="{{asset('/assets/images/structure/setting-icon.svg')}}" alt=".." class="icon24" />
                </a>        
            @else
                <a href="{{ route('hm_bankinfo',auth()->user()->id) }}" class="setting-icon">
                    <img src="{{asset('/assets/images/structure/setting-icon.svg')}}" alt=".." class="icon24" />
                </a>
            @endif
            <div class="dropdown">
            <button class="dropdown-toggle" type="button" id="afterLoginMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('/assets/images/structure/profile_default.png')}}" alt=".." class="icon36round" />
                <span>{{ auth()->user()->full_name }}</span>
            </button>
                <ul class="dropdown-menu" aria-labelledby="afterLoginMenu">
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            <img src="{{asset('/assets/images/structure/dashboard-icon.svg')}}" alt=".." class="icon24" />
                            <span>{{ __('home.dashboard') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".changePassword">
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