<div class="main-wrapper-gray">
	<button class="openSidebar-btn"></button>
	<div class="left-sidebar-main">
		<!-- <button class="closeSidebar-btn">×</button>  -->
		<div class="sidebar-menu">
			<ul class="sidebar-menu-ul">
				@if (auth()->user()->access == 'customer')
				<li class="nav-item {{ (Route::getCurrentRoute()->getName() == 'my-bookings')?'active':'' }}">
					<a href="{{ route('my-bookings'); }}" class="nav-link">
						<img src="{{asset('/assets/images/')}}/structure/my-bookings.svg" alt="" class="sidebarIcon" />
						{{ __('home.myBookings') }}
					</a>
				</li>
				<li class="nav-item {{ (Route::getCurrentRoute()->getName() == 'chat')?'active':'' }}">
					<a href="{{ route('chat'); }}" class="nav-link">
						<img src="{{asset('/assets/images/')}}/structure/chat.svg" alt="" class="sidebarIcon" />
						{{ __('home.chat') }}
						<div class="number-counter" id="chatCount">{{ getUnreadMessage() }}</div>
					</a>
				</li>
				<li class="nav-item {{ (Route::getCurrentRoute()->getName() == 'my-favorites')?'active':'' }}">
					<a href="{{ route('my-favorites'); }}" class="nav-link">
						<img src="{{asset('/assets/images/')}}/structure/heart.svg" alt="" class="sidebarIcon" />
						{{ __('home.favorite') }}
					</a>
				</li>
				<li class="nav-item {{ (Route::getCurrentRoute()->getName() == 'my-rewards')?'active':'' }}">
					<a href="{{ route('my-rewards'); }}" class="nav-link">
						<img src="{{asset('/assets/images/')}}/structure/earnings-payouts.svg" alt="" class="sidebarIcon" />
						{{ __('home.myRewards') }}
					</a>
				</li>
				<li class="nav-item {{ (Request::segment(1) =='my-notifications' || Request::segment(1) =='notification-setting')?'active':'' }}">
					<a href="{{ route('my-notifications'); }}" class="nav-link">
						<img src="{{asset('/assets/images/')}}/structure/notifications.svg" alt="" class="sidebarIcon" />
						{{ __('home.notifications') }}
						<div class="number-counter">0</div>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</div>