<button class="openSidebar-btn"></button>
        <div class="left-sidebar-main">
            <!-- <button class="closeSidebar-btn">×</button> -->
            <div class="sidebar-menu">
                <ul class="sidebar-menu-ul">
                    @if (auth()->user()->access == 'hotel_staff') 
                    <li class="nav-item">
                        <a href="{{ route('bookings'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/my-bookings.svg" alt="" class="sidebarIcon" /> {{ __('home.BookingManagement') }}</a>
                    </li>
                    @endif
                    @if (auth()->user()->access == 'hotel_manager')
                    <li class="nav-item {{ (Request::segment(1) =='dashboard')?'active':'' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/dashboard.svg" alt="" class="sidebarIcon" /> {{ __('home.dashboard') }}</a>
                    </li>
                    <li class="nav-item {{ (Request::segment(1) =='hm_basic_info' || Request::segment(1) =='hm_addressNAttractions')?'active':'' }}">
                        <a href="{{ route('hm_basic_info',auth()->user()->id) }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> {{ __('home.hotelManagement') }}</a>
                    </li>
                    <li class="nav-item {{ (Request::segment(1) =='bookings')?'active':'' }}">
                        <a href="{{ route('bookings'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/my-bookings.svg" alt="" class="sidebarIcon" /> {{ __('home.BookingManagement') }}</a>
                    </li>
                    <li class="nav-item dropdown sidebarDropdown {{ (Request::segment(1) =='rooms')?'open':'' }}">
                        <a href="#" class="nav-link dropdown-toggle {{ (Request::segment(1) =='rooms')?'show':'' }}" data-bs-toggle="dropdown" aria-expanded="{{ (Request::segment(1) =='rooms')?'ture':'false' }}"> <img src="{{asset('/assets/images/')}}/structure/room-management.svg" alt="" class="sidebarIcon" /> {{ __('home.roomManagement') }}</a>
                        <ul class="dropdown-menu {{ (Request::segment(1) =='rooms' || Request::segment(1) =='room-calendar')?'show':'' }}" style="{{ (Request::segment(1) =='rooms' || Request::segment(1) =='room-calendar')?'position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(0px, -139.333px);':''; }}">
                            <li>
                                <a class="dropdown-item {{ (Request::segment(1) =='rooms')?'active':'' }}" href="{{ route('rooms') }}">
                                {{ __('home.rooms') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ (Request::segment(1) =='room-calendar')?'active':'' }}" href="{{ route('room-calendar'); }}">
                                {{ __('home.roomCalendar') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/chat.svg" alt="" class="sidebarIcon" /> {{ __('home.chat') }}
                            <div class="number-counter">12</div>
                        </a>
                    </li>
                    <li class="nav-item {{ (Request::segment(1) =='coupon-list' || Request::segment(1) =='coupon-input')?'active':'' }}">
                        <a href="{{ route('coupon-list'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/coupon-codes.svg" alt="" class="sidebarIcon" />  {{ __('home.couponCodes') }}</a>
                    </li>
                    <li class="nav-item {{ (Request::segment(1) =='my-notifications' || Request::segment(1) =='notification-setting')?'active':'' }}">
                        <a href="{{ route('my-notifications'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/notifications.svg" alt="" class="sidebarIcon" />  {{ __('home.notifications') }}
                            <div class="number-counter">0</div>
                        </a>
                    </li>
                    <li class="nav-item {{ (Request::segment(1) =='my-payouts')?'active':'' }}">
                        <a href="{{ route('my-payouts'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/earnings-payouts.svg" alt="" class="sidebarIcon" />  {{ __('home.earningsAndPayouts') }}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>