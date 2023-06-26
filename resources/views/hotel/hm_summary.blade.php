@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
<!-- include left bar here -->
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
             @include('admin.leftbar')        
         @else
             @include('hotel.leftbar')
         @endif
        <div class="content-box-right hotel-management-sec">
            @include('hotel.complete_percentage')
            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                    @include('hotel.hotel_manage_stepbar')
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <form id="hm_summary_form" method="post">
                            <div class="">
                                <div class="hotelManageform-Content">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                            <div class="whiteBox-w SummaryDetailBox">
                                                <div class="">
                                                    <h5 class="hd5 h5">{{ __('home.summary') }}</h5>
                                                    <div class="row ">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="summeryattDetailRow d-flex align-items-center">
                                                                <div class="summeryHtlimageBox">
                                                                    <img src="{{asset('/hotel_logo/'.$hotel->logo); }}" alt="" class="summeryHtlimage" style="display:{{($hotel->logo !='' )?'block':'none'; }}">
                                                                    <img src="{{asset('/assets/images/')}}/structure/photo.png" alt="" class="summeryHtlimage" style="display:{{($hotel->logo =='' )?'block':'none'; }}">
                                                                </div>
                                                                <div class="summeryDetailDes">
                                                                    <p class="p2 mb-2">{{ $hotel->hotel_name}}</p>
                                                                    <p class="p4 mb-0">{{ $hotel->street }} {{ $hotel->city }} {{ $hotel->subrub }} {{ $hotel->pincode }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <p class="p2">{!! $hotel->description; !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="whiteBox-w attractionsBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.nearByTouristAttractions') }}</h6>
                                                    @if(count($hotel->hasAttractions) >0)
                                                    <div class="row">
                                                        @php
                                                        $ntaCounter=0;
                                                        @endphp
                                                        @foreach ($hotel->hasAttractions as $nta)
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="attdetailRow d-flex flex-wrap mb-3">
                                                                <div class="attdetailLeftName p2">
                                                                {{ __('home.attractionName') }} : 
                                                                </div>
                                                                <div class="attdetailLeftValue p2">
                                                                    {{$nta->attractions_name}}
                                                                </div>
                                                            </div>
                                                            <div class="attdetailRow addressRow d-flex flex-wrap mb-3">
                                                                <div class="attdetailLeftName p2">
                                                                {{ __('home.address') }} :
                                                                </div>
                                                                <div class="attdetailLeftValue p2">
                                                                    {{$nta->nta_address}}
                                                                </div>
                                                            </div>
                                                            <div class="attdetailRow descriptionRow d-flex flex-wrap mb-3">
                                                                <div class="attdetailLeftName p2">
                                                                {{ __('home.description') }} :
                                                                </div>
                                                                <div class="attdetailLeftValue p2">
                                                                    {!! $nta->nta_description; !!}
                                                                </div>
                                                            </div>
                                                            @if($ntaCounter != count($hotel->hasAttractions)-1 )
                                                            <div class="divider"></div>
                                                                @php
                                                                $ntaCounter++;
                                                                @endphp
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        N.A.
                                                    </div>
                                                    </div>                
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="whiteBox-w policiesHtlDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.policies') }}</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                  {{ __('home.checkIn') }} {{ __('home.time') }} :
                                                                </div>
                                                                @if($hotel->check_in !='')
                                                                <div class="policiesLeftValue p2">
                                                                  {{ $hotel->check_in }} 
                                                                </div>
                                                                @else
                                                                    N.A.
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.checkout') }} {{ __('home.time') }} :
                                                                </div>
                                                                @if($hotel->check_out !='')
                                                                <div class="policiesLeftValue p2">
                                                                    {{ $hotel->check_out }}
                                                                </div>
                                                                @else
                                                                    N.A.
                                                                @endif    
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.hotelPolicy') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                @if($hotel->hotel_policy !='')
                                                                {!! $hotel->hotel_policy; !!} 
                                                                @else
                                                                N.A. 
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="whiteBox-w cancelpoliciesHtlDetailBox">
                                                <h6 class="hd6 h6 mb-4">{{ __('home.cancellationPolicies') }}</h6>
                                                <div class="row">
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.theDay') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->same_day_refund == "100")?'Fully ':''; }}{{ ($hotel->same_day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->same_day_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 1 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_1day_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_1day_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_1day_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 2 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_2days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_2days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_2days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 3 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_3days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_3days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_3days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 4 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_4days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_4days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_4days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 5 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_5days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_5days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_5days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 6 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_6days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_6days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_6days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 7 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_7days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_7days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_7days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 8 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_8days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_8days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_8days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 9 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_9days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_9days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_9days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                        <div class="circleBefor"></div>
                                                        <div class="cancellationPolicycnt d-flex align-items-center">
                                                            <span class="bgpink"></span>
                                                            <div class="cancellationPolicyCol1">
                                                                <p class="p2 mb-0">{{ __('home.before') }} 10 {{ __('home.day') }}</p>
                                                            </div>
                                                            <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                                <p class="p2 mb-0">{{ ($hotel->b4_10days_refund == "100")?'Fully ':''; }}{{ ($hotel->b4_10days_refund == "0")?'No Refund':'Refundable'; }}</p>
                                                                <p class="p3 mb-0">({{ __('home.youWillGet') }} <span class="cpPercent">{{ $hotel->b4_10days_refund}}%</span> {{ __('home.refund') }})</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php /* 
                                            <div class="whiteBox-w termsConditionHtlDetailBox">
                                                <h6 class="hd6 h6">{{ __('home.TermsandConditionsg') }}</h6>
                                                <p class="p2">
                                                @if($hotel->terms_and_conditions !='')
                                                    {!! $hotel->terms_and_conditions; !!}
                                                @else
                                                    N.A. 
                                                @endif    
                                                </p>
                                            </div>
                                            */ 
                                            @endphp
                                            <div class="whiteBox-w hotelFeaturesHtlDetailBox">
                                                <h6 class="hd6 h6">{{ __('home.hotelFeatures') }}</h6>
                                                @if(count($hotel_features) >0)
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                    @foreach ($hotel_features as $hotel_feature)    
                                                     <p class="selectchip">{{$hotel_feature->features_name}}</p>
                                                     @endforeach
                                                     <!-- <p class="selectchip">Spa</p> --> 
                                                </div>
                                                @else
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">N.A.</div>
                                                @endif
                                            </div>
                                            <div class="whiteBox-w hotelFacilitiesHtlDetailBox">
                                                <h6 class="hd6 h6">{{ __('home.hotelFacilities') }}</h6>
                                                @if(count($hotel_facilities) >0)
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                    @foreach ($hotel_facilities as $facilitie)
                                                    <p class="selectchip">{{$facilitie->facilities_name}} </p>
                                                    @endforeach
                                                    <!-- <p class="selectchip">Poolside bar <span class="closechps">×</span></p> -->
                                                </div>
                                                @else
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">N.A.</div> 
                                                @endif                                               
                                            </div>
                                            <div class="whiteBox-w extraServiceHtlDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6"> {{ __('home.extraService') }}</h6>
                                                    @if(count($hotel->hasExtraServices) >0)
                                                    <div class="row">
                                                        @php
                                                        $ExSCounter=0;
                                                        @endphp
                                                        @foreach ($hotel->hasExtraServices as $es)
                                                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                 {{ __('home.ServiceName') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{$es->es_name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.unitPrice') }}  :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    ₩ {{$es->es_price}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.maxQty') }}  :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{$es->es_max_qty}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($ExSCounter != count($hotel->hasExtraServices)-1 )
                                                        <div class="divider mb-3"></div>
                                                        @php
                                                        $ExSCounter++;
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> 
                                                              N.A.  
                                                        </div>
                                                    </div>                                                  
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="whiteBox-w extraServiceHtlDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.longStayDiscount') }} </h6>
                                                    @if(count($hotel->hasLongStayDiscount) >0)
                                                    @php
                                                        $LSDCounter=0;
                                                        @endphp
                                                        @foreach ($hotel->hasLongStayDiscount as $lsd)
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                 {{ __('home.minDaysStays') }} ( {{ __('home.Nights') }}) :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{$lsd->lsd_min_days}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.maxDaysStays') }} ({{ __('home.Nights') }}) :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{$lsd->lsd_max_days}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.discount') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    @if($lsd->lsd_discount_type =='percentage')
                                                                        {{ $lsd->lsd_discount_amount}}%
                                                                    @else
                                                                     ₩ {{ $lsd->lsd_discount_amount}}
                                                                    @endif 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($LSDCounter != count($hotel->hasLongStayDiscount)-1 )
                                                        <div class="divider mb-3"></div>
                                                        @php
                                                        $LSDCounter++;
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                    @else
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> 
                                                              N.A.  
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="whiteBox-w extraServiceHtlDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.peakSAeason') }}</h6>
                                                    @if(count($hotel->hasPeakSeasont) >0)
                                                    @php
                                                        $PSCounter=0;
                                                        @endphp
                                                        @foreach ($hotel->hasPeakSeasont as $ps)
                                                        @php
                                                        $sdate=date_create($ps->start_date);
                                                        $edate=date_create($ps->end_date);
                                                        @endphp
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                 {{ __('home.seasonName') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{$ps->season_name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.startDate') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                   {{  date_format($sdate,"Y-m-d") }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.endDate') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{  date_format($edate,"Y-m-d") }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($PSCounter != count($hotel->hasPeakSeasont)-1 )
                                                        <div class="divider mb-3"></div>
                                                        @php
                                                        $PSCounter++;
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                    @else
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> 
                                                              N.A.  
                                                        </div>
                                                    </div>
                                                    @endif                                                                                                      
                                                </div>
                                            </div>
                                            @if(auth()->user()->access == 'admin')
                                            <div class="whiteBox-w BankDetailBox"id="BankDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.bankDetails') }}</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                    {{ __('home.bankName') }} :
                                                                </div>
                                                                @if(isset($hotel->hasHotelBankAcDetails->bank_name) && $hotel->hasHotelBankAcDetails->bank_name !='')
                                                                <div class="policiesLeftValue p2">
                                                                  {{ $hotel->hasHotelBankAcDetails->bank_name }} 
                                                                </div>
                                                                @else
                                                                    N.A.
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.accountNo') }} :
                                                                </div>
                                                                @if(isset($hotel->hasHotelBankAcDetails->account_num) && $hotel->hasHotelBankAcDetails->account_num !='')
                                                                <div class="policiesLeftValue p2">
                                                                    {{ $hotel->hasHotelBankAcDetails->account_num }}
                                                                </div>
                                                                @else
                                                                    N.A.
                                                                @endif    
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="policiesRow d-flex flex-wrap mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.accountHolderName') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                @if(isset($hotel->hasHotelBankAcDetails->ac_holder_name) && $hotel->hasHotelBankAcDetails->ac_holder_name !='')
                                                                {{ strip_tags($hotel->hasHotelBankAcDetails->ac_holder_name); }} 
                                                                @else
                                                                N.A. 
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 HotelImagesCl">
                                            <div class="whiteBox-w">
                                                <h6 class="h6 hd6">{{ __('home.HotelImages') }}</h6>
                                                <div>
                                                    @if(count($hotel->hasImage) >0)
                                                    <div id="hotelslider" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $imgCounter1 =0;
                                                            @endphp
                                                            @foreach ($hotel->hasImage as $img1)
                                                            <div class="carousel-item hotelslides {{ ($imgCounter1==0)?'active':''; }}">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/hotel_images/'.$img1->image); }}" alt="" class="rootypeImage">
                                                            </div>
                                                            @php
                                                                $imgCounter1++;
                                                            @endphp
                                                            @endforeach    
                                                            <!-- <div class="carousel-item hotelslides">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/assets/images/')}}/product/rootype2.png" alt="" class="rootypeImage">
                                                            </div>
                                                            <div class="carousel-item hotelslides">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/assets/images/')}}/product/rootype2.png" alt="" class="rootypeImage">
                                                            </div> -->
                                                        </div>
                                                        @if(count($hotel->hasImage) >1)
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#hotelslider" data-bs-slide="prev">
                                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                          <span class="visually-hidden">{{ __('home.Previous') }}</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#hotelslider" data-bs-slide="next">
                                                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                          <span class="visually-hidden">{{ __('home.Next') }}</span>
                                                        </button>
                                                        @endif
                                                        <div class="carousel-indicators hotelImagesSmRow">
                                                        @php
                                                        $imgCounter2 =0;
                                                        @endphp
                                                        @foreach ($hotel->hasImage as $img2)
                                                        @if($imgCounter2==0)
                                                        <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="{{ $imgCounter2; }}" class="active" aria-current="true" aria-label="Slide {{ $imgCounter2; }}">
                                                            <div class="overlay"></div>
                                                            <img src="{{asset('/hotel_images/'.$img2->image); }}" alt="" class="rootypeImage">
                                                        </button>
                                                        @else
                                                        <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="{{ $imgCounter2; }}" aria-label="Slide {{ $imgCounter2; }}">
                                                            <div class="overlay"></div>
                                                            <img src="{{asset('/hotel_images/'.$img2->image); }}" alt="" class="rootypeImage">
                                                        </button>
                                                        @endif 
                                                        @php
                                                            $imgCounter2++;
                                                        @endphp
                                                        @endforeach 
                                                            <!-- <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="1" aria-label="Slide 2">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/assets/images/')}}/product/rootype2.png" alt="" class="rootypeImage">
                                                            </button>
                                                            <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="2" aria-label="Slide 3">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/assets/images/')}}/product/rootype3.png" alt="" class="rootypeImage">
                                                            </button> -->
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                   <a href="{{route('hm_otherInfo',$hotel->hotel_id)}}" class="btn-back btnPrevious">Back</a>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.cancel') }}</a>
                                    <button type="button" class="btn btnNext tab3 form_submit" data-btntype="next">{{ __('home.Save') }}</button>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Thank you Modal -->
<div class="modal fade thankyouDialog successDialog" tabindex="-1" aria-labelledby="thankyouDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads">
                    <div class="text-center">
                        <img src="{{asset('/assets/images/')}}/structure/checked-thankyou.svg" alt="" class="">
                        <h3 class="h3 mt-2">{{ __('home.thankYou') }}!</h3>
                        <p class="p2 mb-4">{{ __('home.YourHotelHasBeenAddedSuccessfully') }}</p>
                    </div>
                    <a href="{{route('hm_bankinfo',$hotel->hotel_id); }}" class="btn w-100">{{ __('home.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script src="//cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<script>
$(document).ready(function() {
    //editor
    // $(document).ready(function () { $('.ckeditor').ckeditor(); });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    function animateElements() {
        $('.progressbar').each(function() {
            var elementPos = $(this).offset().top;
            var topOfWindow = $(window).scrollTop();
            var percent = $(this).find('.circle').attr('data-percent');
            var animate = $(this).data('animate');
            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                $(this).data('animate', true);
                $(this).find('.circle').circleProgress({
                    startAngle: -Math.PI / 2,
                    value: percent / 100,
                    size: 55,
                    thickness: 5,
                    fill: {
                        color: '#015AC3'
                    }
                }).on('circle-animation-progress', function(event, progress, stepValue) {
                    $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
                }).stop();
            }
        });
    }
    animateElements();
    $(window).scroll(animateElements);
})
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        function form_submit()
        { 
            var token=true; 
            let formdata = $( "#hm_summary_form" ).serialize();
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                $.post("{{ route('hm_summary_submit') }}",  formdata, function( data ) {
                            // console.log(data);
                            // unloading();
                            if(data.status==1){
                                $('.thankyouDialog').modal('show'); 
                                // thankyouDialog
                                //window.location.href = data.nextpageurl; 
                                unloading();
                            } 
                            else
                            {
                                $(".form_submit").prop("disabled",false); 
                                // $('#hm_hm_server_err_msg').text(data.message);
                                unloading();
                            }                      
                });             
            }
        }     
    });
</script>
@endsection       