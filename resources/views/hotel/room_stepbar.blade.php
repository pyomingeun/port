<div class="hotel-management-left-col">
    <div class="hotel-tabs-rw">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="{{ route('room_basic_info',$slug) }}" class="nav-link tab1 {{ (isset($room->basic_info_status) && $room->basic_info_status==1)?' activep':''; }}{{ (Request::segment(1) =='room_basic_info')?' active':'' }}">
                    <span class="stepcircle">1 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 1</p>
                        <p class="p1">{{ __('home.RoomInfo') }}</p> 
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('room_features_n_facilities',$slug) }}" class="nav-link tab3 {{ (isset($room->roomfnf_status) && $room->roomfnf_status==1)?' activep':''; }}{{ (Request::segment(1) =='room_features_n_facilities')?' active':'' }}">
                    <span class="stepcircle">2 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 2</p>
                        <p class="p1"> {{ __('home.RoomFeatureFacility') }} </p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('room_occupancy_n_pricing',$slug) }}" class="nav-link tab4 {{ (isset($room->pricing_status) && $room->pricing_status==1)?' activep':''; }}{{ (Request::segment(1) =='room_occupancy_n_pricing')?' active':'' }}">
                    <span class="stepcircle">3 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 3</p>
                        <p class="p1">{{ __('home.OccupancyPricing') }} </p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('room_summary',$slug) }}" class="nav-link tab4 {{ (isset($room->status) && $room->status=='active')?' activep':''; }}{{ (Request::segment(1) =='room_summary')?' active':'' }}">
                    <span class="stepcircle">4 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 4</p>
                        <p class="p1">{{ __('home.RoomInfoSummary') }}</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>