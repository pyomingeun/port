<div class="hotel-management-left-col">
    <div class="hotel-tabs-rw">
        <ul class="nav nav-tabs">
            <li class="nav-item ">
                <a href="{{route('hm_basic_info',$hotel->hotel_id)}}" class="nav-link tab1 {{ ($hotel->basic_info_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_basic_info')?' active':'' }}">
                    <span class="stepcircle">1 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 1</p>
                        <p class="p1">{{ __('home.hotelInfo') }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('hm_addressNAttractions',$hotel->hotel_id)}}" class="nav-link tab2 {{ ($hotel->address_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_addressNAttractions')?' active':'' }}">
                    <span class="stepcircle">2 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 2</p>
                        <p class="p1">{{ __('home.addressInfo') }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('hm_policies',$hotel->hotel_id)}}" class="nav-link tab3 {{ ($hotel->hpolicies_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_policies')?' active':'' }}">
                    <span class="stepcircle">3 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 3</p>
                        <p class="p1">{{ __('home.Policies') }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('hm_FeaturesNFacilities',$hotel->hotel_id)}}" class="nav-link tab4 {{ ($hotel->fnf_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_FeaturesNFacilities')?' active':'' }}">
                    <span class="stepcircle">4 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 4</p>
                        <p class="p1">{{ __('home.Amenities') }} &  {{ __('home.Facilities') }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('hm_otherInfo',$hotel->hotel_id)}}" class="nav-link tab5 {{ ($hotel->other_info_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_otherInfo')?' active':'' }}">
                    <span class="stepcircle">5 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 5</p>
                        <p class="p1">{{ __('home.otherInfo') }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('hm_summary',$hotel->hotel_id)}}" class="nav-link tab6 {{ ($hotel->summary_status==1)?' activep':''; }}{{ (Request::segment(1) =='hm_summary')?' active':'' }}">
                    <span class="stepcircle">6 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
                    <div class="tabCnt">
                        <p class="p3">{{ __('home.Step') }} 6</p>
                        <p class="p1">{{ __('home.summary') }}</p>
                    </div>
                </a>
            </li>
        </ul>
        @if($hotel->completed_percentage < 100)
        <div class="informBox">
            <p class="p3 mb-0" style="display: flex; align-items: center;">
              <img src="{{asset('/assets/images/')}}/structure/info-orange.svg" alt="" class="informicon" style="margin-right: 5px; vertical-align: middle;">
              <span style="font-size: 16px;">{{ __('home.Yourlistingwillnotbepublishedunlessbankdetailsisprovided') }}</span>
            </p>
        </div>
        @endif
    </div>
</div>
