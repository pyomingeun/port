@extends('frontend.layout.head')
@section('body-content')
  @include('frontend.layout.header')
  <style>
    .tooltipbox {
    max-height: 250px !important;
    width: 300px !important;
    overflow: auto;
    }
  </style>  
    <div class="main-wrapper" style="padding-top: 0;">
        <img class="dotted-img-bd" src="{{ asset('/assets/images/') }}/structure/dotted-img.png" alt="">
        <section class="home-sec1 hotel-detail-sec1">
            <div class="container bannerSearchContainer">
                <div class="row">
                    <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12 mx-auto">
                    <x-search-hotel-form />
                    </div>
                </div>
            </div>
        </section>
        <section class="hotel-detail-sec2">
            @if(isset($lsd) && $lsd > 0)
            <div class="newtag">
                <img src="{{ asset('/assets/images/') }}/structure/correct-white-icon.svg" alt="" class="icon20" />
                <span>Long stay discount applied</span>
            </div>
            @endif
            <div class="container">
                <nav aria-label="breadcrumb" class="breadcrumbNave">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home'); }}">{{ __('home.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotel-list'). getQueryParams(array_merge(Request::all())); }}">{{ __('home.Hoteles') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $hotel->hotel_name }}</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                        <div class="d-flex align-items-center justify-content-start">
                            <h3 class="h3">{{ $hotel->hotel_name}} </h3>
                            <div class="rat-review d-flex align-items-center">
                                <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ number_format($hotel->rating,1); }}</span>
                                @if($hotel->rating > 4 && $hotel->rating <= 5)
                                <span class="exs-text">{{ __('home.excellent') }}</span>
                                @elseif($hotel->rating <= 4 && $hotel->rating > 3)
                                <span class="exs-text">{{ __('home.veryGood') }}</span>
                                @elseif($hotel->rating <= 3 && $hotel->rating > 2)
                                <span class="exs-text">{{ __('home.Average') }}</span>
                                @elseif($hotel->rating <= 2 && $hotel->rating > 1)
                                <span class="exs-text">{{ __('home.Poor') }}</span>
                                @elseif($hotel->rating < 1)
                                <span class="exs-text">{{ __('home.Terrible') }}</span>
                                @endif
                                <a href="#reviews" class="p2 mb-0 mt-0" style="color: #191C1A;">{{ $hotel->reviews; }} Reviews</a>
                            </div>
                        </div>
                        <p class="p2">{{ $hotel->street }}{{ ($hotel->city !='' && $hotel->street !='')?', ':''; }} {{ $hotel->city }}{{ ($hotel->city !='' && $hotel->subrub !='')?', ':''; }}{{ $hotel->subrub  }} {{ ($hotel->pincode !='')?' - ':''; }}{{ $hotel->pincode }}</p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 sahreFavoriteBox d-flex align-items-center justify-content-end">
                        @php
                        $twitter_params = 
                        '?text=' . urlencode($hotel->hotel_name) . '+-' .
                        '&amp;url=' . urlencode(route('hotel-detail', $hotel->slug)) . 
                        '&amp;counturl=' . urlencode(route('hotel-detail', $hotel->slug)) .
                        '';
                        $twitterlink = "http://twitter.com/share" . $twitter_params . "";
                        @endphp 
                        <div class="shareFropdown dropdown">
                            <a class="dropdown-toggle d-flex align-items-center" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown">
                                <img src="{{ asset('/assets/images/') }}/structure/share.svg" alt="" class="shareIcon"> {{ __('home.Share') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="https://www.facebook.com/sharer.php?u={{route('hotel-detail', $hotel->slug)}}&t={{ $hotel->hotel_name }}" style="color:#4267B2;"><img src="{{ asset('/assets/images/') }}/structure/facebook-blue.svg" alt="" class="facebook">Facebook</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ $twitterlink;  }}" style="color:#1DA1F2;"><img src="{{ asset('/assets/images/') }}/structure/twitter-blue.svg" alt="" class="twitter">Twitter</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javaScript:void(0);" style="color:#191C1A;" data-link="{{route('hotel-detail', $hotel->slug)}}" onclick="copyLink()" id="copyLink"><img src="{{ asset('/assets/images/') }}/structure/copy-gray.svg" alt=""  class="copy"  >{{ __('home.CopyLink') }}</a>
                                </li>
                            </ul>
                        </div>
                        @if (auth()->user() && auth()->user()->id != '')
                        <p class="p2 mb-0 cursor-p favoriteItem d-flex align-items-center "><img src="{{ asset('/assets/images/') }}/structure/{{ ($isMyFavorite >0 )?'heart-fill.svg':'heart-outline.svg'; }}" alt="" class="favoriteItem markunmarkfavorite cursor-pointer" data-h="{{ $hotel->hotel_id }}" id="markunmarkfavoriteicon" > {{ __('home.favorite') }}</p>
                        @else
                        <p class="p2 mb-0 cursor-p favoriteItem d-flex align-items-center "><img src="{{ asset('/assets/images/') }}/structure/{{ ($isMyFavorite >0 )?'heart-fill.svg':'heart-outline.svg'; }}" data-bs-toggle="modal" data-bs-target=".loginDialog" class="favoriteItem cursor-pointer" > {{ __('home.favorite') }}</p>
                        @endif  
                    </div>
                </div>
                @if(count($hotel->hasImageActive) >0)
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="hotelDetilSlider sliderArrow">
                            @foreach ($hotel->hasImageActive as $hotelImg)
                            <div class="hotelDetilSlides">
                                <img
                                    src="{{ asset('/hotel_images/'.$hotelImg->image); }}"
                                    class="hotelimg" alt=""
                                    onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                >
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <div class="row hotel-detail-des-box1">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                        @php /* 
                        <div class="rat-review d-flex align-items-center">
                            <span class="rat-chips"><i class="fa fa-star" aria-hidden="true"></i> {{ number_format($hotel->rating,1); }} </span>
                            <span class="p2 mb-0 mt-0" style="color: #191C1A;">{{ $hotel->reviews; }} Reviews</span>
                        </div>
                        */ @endphp
                        {{-- <h3 class="h3 mb-3">About {{ $hotel->hotel_name}}</h3> --}}
                        <div class="d-flex align-items-center">
                            <p class="checkin mb-0">{{ __('home.checkIn') }} - <span>{{ $hotel->check_in; }}</span></p>
                            <span class="vertLine">|</span>
                            <p class="checkout mb-0">{{ __('home.checkOut') }} - <span>{{ $hotel->check_out; }}</span></p>
                            @auth()
                            <span class="vertLine">|</span>
                            <a class="quickEnquiry cursor-p" href="#" data-bs-toggle="modal" data-bs-target=".quickEnquiryDialog">{{ __('home.quickEnquiry') }}</a>
                            @endauth
                        </div>
                        <div class="p2">{!!  $hotel->description !!}</div>
                    </div>
                    <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="detailMapBox">
                            <img src="{{ asset('/assets/images/') }}/product/map-imageSm.png" alt="" class="htl-dtlmap-image">
                            <div class="onmapCnt text-center">
                                <img src="{{ asset('/assets/images/') }}/structure/map-marker-blue.svg" alt="" class="htl-dtlmap-Icon d-block m-auto">
                                <button class="btn bg-blue h-36">Show Map</button>
                            </div>
                        </div>
                    </div> -->
                </div>
                @if(count($rooms) > 0)
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="room-type-box">
                            <h5 class="50">{{ __('home.roomType') }}</h5>
                            @foreach ($rooms as $room)
                            @php
                                $urlPara = array("h"=>$hotel->slug,"r"=>$room->slug);
                            @endphp
                            <div class="roomtype-row d-flex mb-3">
                                <div class="roomtypeslidermainbox">
                                    <div class="roomtypesliderbox sliderArrow">
                                        @foreach ($room->hasImagesActive as $rimage)
                                         @php
                                            $rimageCounter =0;
                                        @endphp
                                        <div class="roomtypeslides" data-bs-toggle="modal" data-bs-target=".roomfullview{{$room->id}}">
                                            <img
                                                src="{{asset('/room_images/'.$rimage->room_image); }}"
                                                alt="" class="rootypeImage" data-bs-target="#slider-slides"
                                                onerror="this.onerror=null;this.src='{{ asset('/assets/images/structure/hotel_default.png') }}';"
                                                data-bs-slide-to="0">
                                        </div>
                                        @php
                                            $rimageCounter++;
                                        @endphp
                                        @endforeach                                        
                                    </div>
                                </div>
                                <div class="roomtypeDescription">
                                    <div class="roomtypeDescriptionRow1">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                                <h5 class="h5">{{ $room->room_name }}  <span class="chips chips-orange h-24 {{ ($room->isRoomBooked)?'':'display-none'; }}">Sold Out</span></h5>
                                                <div class="roomdtlrw1 d-flex flex-wrap align-items-center">
                                                    <p class="p2 mb-0"><img src="{{ asset('/assets/images/') }}/structure/tracked.svg" alt="" class="rDtlIcon"> {{ $room->room_size }} sq m</p>
                                                    @if(isset($room->hasBedsActive) && count($room->hasBedsActive) >0)
                                                    <p class="p2 mb-0"><img src="{{ asset('/assets/images/') }}/structure/bouble-bed.svg" alt="" class="rDtlIcon">
                                                    @php
                                                        $bedCounter = 0;
                                                    @endphp
                                                    @foreach ($room->hasBedsActive as $bed)
                                                        @if($bedCounter == 0)
                                                            {{ $bed->bed_type }} x {{ $bed->bed_qty }}
                                                        @else
                                                            {{ $bed->bed_type }} x {{ $bed->bed_qty }}
                                                        @endif
                                                    @php
                                                        $bedCounter++;
                                                    @endphp
                                                    @endforeach
                                                    </p>
                                                    @endif
                                                </div>
                                                <div class="roomdtlrw2 d-flex flex-wrap align-items-center">
                                                    @if(isset($room->room_facilities[0]->facilities_name))
                                                    <span class="dotgray"></span>
                                                    <p class="p2 mb-0">{{$room->room_facilities[0]->facilities_name; }}</p>
                                                    @endif
                                                    @if(isset($room->room_facilities[1]->facilities_name))
                                                    <span class="dotgray"></span>
                                                    <p class="p2 mb-0">{{$room->room_facilities[1]->facilities_name; }}</p>
                                                    @endif
                                                    @if(isset($room->room_features[0]->features_name))
                                                    <span class="dotgray"></span>
                                                    <p class="p2 mb-0">{{$room->room_features[0]->features_name; }}</p>
                                                    @endif
                                                    @if(isset($room->room_features[1]->features_name))
                                                    <span class="dotgray"></span>
                                                    <p class="p2 mb-0">{{$room->room_features[1]->features_name; }}</p>
                                                    @endif                                                   
                                                </div>
                                                @if(count($room->room_facilities) >2 || count($room->room_features) >2 )
                                                <a href="#" class="viewmore-a" data-bs-toggle="modal" data-bs-target="#facilitiesFeaturesDialog{{ $room->id }}">View More</a>
                                                @endif
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 d-flex flex-column align-items-end"> 
                                                @if(($room->isRoomBooked) > 0)
                                                <a  class="btn h-32 sold-out-btn">{{ __('home.select') }}</a>
                                                @else
                                                <a href="{{ route('room-checkout'). getQueryParams(array_merge(Request::all(),$urlPara)) }}" class="btn h-32 ">{{ __('home.select') }}</a>                                                
                                                @endif
                                                <div>
                                                    <h6 class="h6 mb-0">₩ {{  siteNumberFormat($room->$roomEffectivePrice) }}</h6>
                                                    <p class="p3 mb-0">{{ __('home.perNight') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="roomtypeDescriptionRow2">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" style="padding-left: 15px;">
                                                <p class="p3 mb-1">{{ __('home.extraGuest') }}</p>
                                                <p class="p2 d-flex align-items-center mb-0"><img src="{{ asset('/assets/images/') }}/structure/user-black.svg"> <span>x 1</span> <span>-</span> <span>₩ {{ $room->extra_guest_fee }}</span></p>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                <p class="p3 mb-1">{{ __('home.standardOccupancy') }}</p>
                                                <p class="p2 d-flex align-items-center mb-0"><img src="{{ asset('/assets/images/') }}/structure/user-black.svg"> <span>x {{ $room->standard_occupancy_adult + $room->standard_occupancy_child }}</span> <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true"
                                                        title="<div class='tooltipbox'> <span class='normalfont'>Adult: <small class='mediumfont'>{{ $room->standard_occupancy_adult }}</small></span> , <span class='normalfont'>Children: <small class='mediumfont'>{{ $room->standard_occupancy_child}}</small></span> </div>"></p>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                <p class="p3 mb-1">{{ __('home.maximumOccupancy') }}</p>
                                                <p class="p2 d-flex align-items-center mb-0"><img src="{{ asset('/assets/images/') }}/structure/user-black.svg"> <span>x {{ $room->maximum_occupancy_adult + $room->maximum_occupancy_child }}</span> <img src="{{ asset('/assets/images/') }}/structure/info-blue.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true"
                                                        title="<div class='tooltipbox'> <span class='normalfont'>Adult: <small class='mediumfont'>{{ $room->maximum_occupancy_adult}}</small></span> , <span class='normalfont'>Children: <small class='mediumfont'>{{ $room->maximum_occupancy_child}}</small></span> </div>"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if(count($hotel_features) >0)
                <div class="row FeaturesAndFacilitiesRow mt-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5 class="h5 mb-4">{{ __('home.HotelAmenities') }}</h5>
                    </div>
                    @foreach ($hotel_features as $hotel_feature)    
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon">{{$hotel_feature->features_name}}</p>
                    </div>
                    @endforeach               
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <a href="#" class="viewmore-a" data-bs-toggle="modal" data-bs-target=".hotelRulesPolicyDialog">View More</a>
                    </div> -->
                </div>
                @endif
                @if(count($hotel_facilities) >0)
                <div class="row FeaturesAndFacilitiesRow mt-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5 class="h5 mb-4">{{ __('home.hotelFacilities') }}</h5>
                    </div>
                    @foreach ($hotel_facilities as $facilitie)
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon">{{$facilitie->facilities_name}} </p>
                    </div>
                    @endforeach
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <a href="#" class="viewmore-a" data-bs-toggle="modal" data-bs-target=".hotelRulesPolicyDialog">View More</a>
                    </div> -->
                </div>
                @endif
                <div class="divider mt-5 mb-5"></div>
                <div class="row FeaturesAndFacilitiesRow">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5 class="h5 mb-4">{{ __('home.rulesAndPolicy') }}</h5>
                        <!-- <div class="checkinout d-flex align-items-center mb-4">
                            <h6 class="h6 mb-0 mt-0"><span>Check In -</span> 12:00 pm</h6>
                            <h6 class="h6 mb-0 mt-0"><span>Check out -</span> 11:00 am</h6>
                        </div> -->
                    </div>
                    {!!  $hotel->hotel_policy !!}
                </div>
                <div class="divider mt-4 mb-5"></div>
                <div class="row">
                    <div class="col-xl-7 col-lg-10 col-md-12 col-sm-12 col-12">
                        <h5 class="h5 mb-3">{{ __('home.cancellationPolicies') }}</h5>
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12 col-12">
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
                        </div>
                    </div>
                </div>
                @if(count($attractions) >0)
                <div class="divider mt-4 mb-5"></div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 TouristAttractionsBlock">
                        <h5 class="h5 mb-4">{{ $hotel->touristAttractions }}</h5>
                        <x-map-pins-attraction :locations="$jsonLocations"/>
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach ($attractions as $nta)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="TouristAttractionsRef d-flex align-items-center mb-3">
                            <div class="tAttImgBox">
                                <img src="{{ asset('/assets/images/') }}/structure/nta-icon.svg" alt="" class="tAttImgBox">
                            </div>
                            <div class="w-100">
                                <p class="p2 mb-1 d-flex justify-content-between aling-items-start "> <span class="text-ellips-v">{{$nta->attractions_name}}</span> <img src="{{asset('/assets/images/')}}/structure/info-gray.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox' >{!! $nta->nta_description !!} </div> "></p>
                                <p class="p3 mb-0">{{ isset($nta->distance)?round($nta->distance,2)." Km":'';  }} </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="divider mt-4 mb-5"></div>
                @endif
                @php /*
                <div class="row FeaturesAndFacilitiesRow">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5 class="h5 mb-4">{{ $hotel->TermsandConditionsg }}</h5>
                        <!-- <div class="checkinout d-flex align-items-center mb-4">
                            <h6 class="h6 mb-0 mt-0"><span>Check In -</span> 12:00 pm</h6>
                            <h6 class="h6 mb-0 mt-0"><span>Check out -</span> 11:00 am</h6>
                        </div> -->
                    </div>
                     {!!  $hotel->terms_and_conditions !!} 
                </div>                
                <div class="divider mt-5 mb-5"></div>
                */ @endphp
                <div class="row" id="reviews">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5 class="h5"> {{ __('home.review') }}</h5>
                        <div class="hotel-dtl-reviewRow d-flex align-items-center">
                            <div class="hotel-dtl-reviewBlock text-center">
                                <h4 class="mb-2 " style="font-weight:bold; ">{{ number_format($hotel->rating,1); }}  @if($hotel->rating > 4 && $hotel->rating <= 5)
                                <span class="exs-text">{{ __('home.excellent') }}</span>
                                @elseif($hotel->rating <= 4 && $hotel->rating > 3)
                                <span class="exs-text">{{ __('home.veryGood') }}</span>
                                @elseif($hotel->rating <= 3 && $hotel->rating > 2)
                                <span class="exs-text">{{ __('home.Average') }}</span>
                                @elseif($hotel->rating <= 2 && $hotel->rating > 1)
                                <span class="exs-text">{{ __('home.Poor') }}</span>
                                @elseif($hotel->rating < 1)
                                <span class="exs-text">{{ __('home.Terrible') }}</span>
                                @endif</h4> 
                                <div class="d-flex justify-content-center">
                                    @for ($i = 1; $i <=5; $i++)
                                        @if($hotel->rating < $i ) 
                                            @if(is_float($hotel->rating) && ($i-$hotel->rating) < 1)
                                                <i class="fa fa-star-half rStargreen"></i>
                                            @else
                                                <i class="fa fa-star rStarwhite"></i>
                                            @endif
                                        @else
                                        <i class="fa fa-star rStargreen"></i>   
                                         @endif    
                                    @endfor
                                </div>
                                <p class="p1 mt-3 mb-0">{{ $hotel->reviews }} {{ __('home.reviews') }}</p>
                            </div>
                            <div class="hotel-dtl-progressratbolck">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="ratprogress mb-4">
                                            <p class="p2 d-flex align-items-center mb-2">Cleanliness<span class="ml-auto">{{ $progressBarCleanliness  }}%</span></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $progressBarCleanliness }}%" aria-valuenow="{{ $progressBarCleanliness }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="ratprogress mb-4">
                                            <p class="p2 d-flex align-items-center mb-2">Facilities<span class="ml-auto">{{ $progressBarFacilities  }}%</span></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $progressBarFacilities }}%" aria-valuenow="{{ $progressBarFacilities }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="ratprogress mb-4">
                                            <p class="p2 d-flex align-items-center mb-2">Service<span class="ml-auto">{{ $progressBarService  }}%</span></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $progressBarService }}%" aria-valuenow="{{ $progressBarService }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="ratprogress mb-4">
                                            <p class="p2 d-flex align-items-center mb-2">Value for money<span class="ml-auto">{{ $progressBarValueformoney  }}%</span></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $progressBarValueformoney }}%" aria-valuenow="{{ $progressBarValueformoney }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($rating_reviews) >0 )
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">                       
                        @foreach ($rating_reviews as $rr)
                        <div class="ratingRow d-flex">
                            
                            <div class="ratingDes">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <div class="new-review-left">
                                            <h6>{{ $rr->full_name}}</h6>
                                            <p class="p3">{{ date_format($rr->created_at,"Y-m-d") }}</p>
                                            <div class="ratingNoBox">{{ siteNumberFormat($rr->avg_rating,1); }}</div>       
                                        </div>                                 
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="p2">{{ $rr->review }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach                       
                    </div>
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                        <a href="#" class="viewmore-a">View More</a>
                    </div> -->
                </div>
                @endif
            </div>
        </section>
    </div>
    <!-- Facilities and Features -->
    @foreach ($rooms as $room)
    <div class="modal fade facilitiesFeaturesDialog" id="facilitiesFeaturesDialog{{$room->id}}" tabindex="-1" aria-labelledby="loginDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads" style="padding:30px 30px 20px 30px !important;">
                        <h4 class="h4 mb-0">{{ __('home.RoomAmenitiesFacilities') }}</h4>
                    </div>
                    <div class="btmLnTabBox">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" >
                              <button class="nav-link active" id="amenities-tab{{ $room->id }}" data-bs-toggle="pill" data-bs-target="#amenities{{ $room->id }}" type="button" role="tab" aria-controls="amenities-tab" aria-selected="true">{{ __('home.Amenities') }}</button>
                            </li>
                            <li class="nav-item" >
                              <button class="nav-link" id="features-tab{{ $room->id }}" data-bs-toggle="pill" data-bs-target="#features{{ $room->id }}" type="button" role="tab" aria-controls="features-tab" aria-selected="false">{{ __('home.Facilities') }}</button>
                            </li>
                        </ul>
                    </div>
                      <div class="tab-content RoomAmenitiesFeaturesCnt" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="amenities{{ $room->id }}" role="tabpanel" aria-labelledby="amenities{{ $room->id }}">
                            <div class="row FeaturesAndFacilitiesRow mt-4">
                                @if(count($room->room_features) > 0 )
                                @foreach ($room->room_features as $feature)
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon">{{ $feature->features_name }}</p>
                                </div>
                                @endforeach
                                @else
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <p class="p2 mb-3">N.A.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="features{{ $room->id }}" role="tabpanel" aria-labelledby="features{{ $room->id }}">
                            <div class="row FeaturesAndFacilitiesRow mt-4">
                            @if(count($room->room_facilities) > 0 )
                            @foreach ($room->room_facilities as $facilitie)
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon">{{ $facilitie->facilities_name }}</p>
                                </div>
                             @endforeach   
                                @else
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <p class="p2 mb-3">N.A.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Hotel Rules & Policy -->
    <div class="modal fade hotelRulesPolicyDialog" tabindex="-1" aria-labelledby="loginDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-0">{{ __('home.hotelRulesAndPolicy') }}</h4>
                    </div>
                    <div class="row FeaturesAndFacilitiesRow mt-4">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="p2 mb-3"><img src="{{ asset('/assets/images/') }}/structure/chck-circle-gary.svg" alt="" class="ffIcon"> Lorem Ipsum is simply dummy text of the printing.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Enquiry modeal -->
    <div class="modal fade quickEnquiryDialog" id="quickEnquiryDialog" tabindex="-1" aria-labelledby="quickEnquiryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3">{{ __('home.quickEnquiry') }}</h3>
                        <p class="p2">{{ __('home.GotaquestionContactusquicklyandeasly') }}</p>
                    </div>
                    <form action="#" id="hotelEnquiry" method="post">
                        <div class="form-floating">
                            <textarea class="form-control" id="floatingInput" placeholder="{{ __('home.WriteHere') }}" style="min-height: 126px;"></textarea>
                            <label for="floatingInput">{{ __('home.WriteHere') }}</label>
                        </div>
                        <button type="submit" class="btn w-100">{{ __('home.send') }} {{ __('home.Enquiry') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Type Dailog -->
    @foreach ($rooms as $room)
    <div class="modal fade roomType-Slider roomfullview{{$room->id}}" tabindex="-1" aria-labelledby="loginDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div id="slider-slides{{$room->id}}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            @php
                                $rimageCounter2 =0;
                            @endphp
                            @foreach ($room->hasImagesActive as $rimage2)
                            <div class="carousel-item {{ ($rimageCounter2 ==0)?'active':''; }} ">
                                <img src="{{asset('/room_images/'.$rimage2->room_image); }}" alt="" class="rootypeImage">
                            </div>
                            @php
                                $rimageCounter2++;
                            @endphp
                            @endforeach
                        </div>
                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#slider-slides{{$room->id}}" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#slider-slides{{$room->id}}" data-bs-slide="next">
                          <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
<!-- newsletter -->
@include('frontend.layout.newsletter')
<!-- footer -->
@include('frontend.layout.footer')
<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection
@section('page-js-include')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
      // mark/unmark favorite
      $(document).on('click','.markunmarkfavorite',function(){
        // delNTA
        var h = $(this).attr('data-h');
        $.post("{{ route('markunmarkfavorite') }}",{_token:"{{ csrf_token() }}",h:h}, function(data){
          if(data.status==1) {
            if(data.markstatus =='marked') { 
              $("#markunmarkfavoriteicon").attr('src', "{{ asset('/assets/images/') }}/structure/heart-fill.svg"); 
            } else {
              $('#markunmarkfavoriteicon').attr('src', "{{ asset('/assets/images/') }}/structure/heart-outline.svg");
            }
            $("#commonSuccessMsg").text(data.coupon.coupon_code_name);
            $("#commonSuccessBox").css('display','block');
            setTimeout(function() { $("#commonSuccessBox").hide(); }, 3000);
            unloading();
          } else {
            unloading();
            $("#commonErrorMsg").text(data.message);
            $("#commonErrorBox").css('display','block');
            setTimeout(function() { $("#commonErrorBox").hide(); }, 3000);
          }
        });
      });
      // __________________
      $('#hotelEnquiry').submit(function (e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "{{ route('hotel-enquiry') }}",
          data: {
            _token: "{{ csrf_token() }}",
            message: $('#floatingInput').val(),
            id:"{{ $hotel->hotel_id}}"
          },
          success: function(data){
            if (data.status == 1) {
              $('#quickEnquiryDialog').modal('hide');
              window.location.href = "{{ route('chat') }}";
            } else {
              $('#quickEnquiryDialog').modal('hide');
            }
          }
        });
      })
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
function copyLink() {
  // Get the text field
  var element = document.getElementById("copyLink");
  var copyText = element.getAttribute("data-link"); ;
  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText);
}
</script>
@endsection