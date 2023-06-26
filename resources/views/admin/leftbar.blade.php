<button class="openSidebar-btn"></button>
<div class="left-sidebar-main">
    <!-- <button class="closeSidebar-btn">×</button> -->
    <div class="sidebar-menu">
        <ul class="sidebar-menu-ul">
            <li class="nav-item {{ (Request::segment(1) =='dashboard')?'active':'' }}">
                <a href="{{ route('dashboard') }}" class="nav-link "> <img src="{{asset('/assets/images/')}}/structure/dashboard.svg" alt="" class="sidebarIcon" /> Dashboard</a>
            </li>
            <li class="nav-item {{ (Request::segment(1) =='hotel_setup' ||  Request::segment(1) =='hotel_managment' ||  Request::segment(1) =='hm_basic_info' || Request::segment(1) =='hm_addressNAttractions')?'active':'' }}">
                <a href="{{ route('hotel_managment') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> Hotel Management</a>
            </li>

            <li class="nav-item {{ (Request::segment(1) =='staff_management')?'active':'' }}">
                <a href="{{ route('staff_management','all') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> Staff Management</a>
            </li>

            <li class="nav-item {{ (Request::segment(1) =='customer_management')?'active':'' }}">
                <a href="{{ route('customer_management') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> Customer Management</a>
            </li>

            <li class="nav-item {{ (Request::segment(1) =='post-management')?'active':'' }}">
                <a href="{{ route('admin-post-list') }}" class="nav-link"> 
                    <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> Post Management</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('bookings') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/my-bookings.svg" alt="" class="sidebarIcon" /> Booking Management</a>
            </li>
           
            <li class="nav-item">
                <a href="{{ route('coupon-list'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/coupon-codes.svg" alt="" class="sidebarIcon" />Coupon Codes</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('my-payouts'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/earnings-payouts.svg" alt="" class="sidebarIcon" /> Earnings & Payouts</a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('rating-review-list'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/earnings-payouts.svg" alt="" class="sidebarIcon" /> Rating & Reviews </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('facilities-list'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/setting-icon.svg" alt="" class="sidebarIcon" /> Facilities Management </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('amenities-list'); }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/setting-icon.svg" alt="" class="sidebarIcon" /> Amenities Management </a>
            </li>

            <li class="nav-item {{ (Request::segment(1) =='newsletter-list')?'active':'' }}">
                <a href="{{ route('newsletter-list') }}" class="nav-link"> <img src="{{asset('/assets/images/')}}/structure/hotel-management.svg" alt="" class="sidebarIcon" /> News-Letter Management</a>
            </li>
        </ul>
    </div>
</div>

