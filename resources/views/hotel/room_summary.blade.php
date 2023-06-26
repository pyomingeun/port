@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right hotel-management-sec add-room-sec">
            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                    <!-- Room stepbar open -->
                    @include('hotel.room_stepbar')
                    <!-- room stepbar close -->
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <div>
                                <form action="javaScript:Void(0);" method="post" id="room_summary_form">
                                <div class="roomsManageform-Content">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                            <div class="whiteBox-w roomsSummaryDetailBox">
                                                <div class="">
                                                    <h5 class="hd5 h5">{{ __('home.summary') }}</h5>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <h6 class="h6 mb-2">{{ isset($room->room_name)?$room->room_name:''; }}</h6>
                                                            <p class="p2 mb-3 d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/tracked.svg" alt="" class="trackedIcon"> {{ isset($room->room_size)?$room->room_size:'0'; }} sq m</p>
                                                            <p class="p3 mb-0">
                                                            @if($room->room_description !='')
                                                                {!! $room->room_description; !!}
                                                            @else
                                                                N.A. 
                                                            @endif 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="whiteBox-w BedsInfolDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.BedsInfo') }}</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                    No. of Bathrooms :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                {{ isset($room->no_of_bathrooms)?$room->no_of_bathrooms:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(isset($room->hasBeds) && count($room->hasBeds) >0)
                                                         @foreach ($room->hasBeds as $bed)
                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName p2">
                                                                {{ __('home.bedType') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    {{ $bed->bed_type }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="whiteBox-w Room RoomFeaturesFacilitiesBox">
                                                <h6 class="hd6 h6">{{ __('home.RoomAmenities') }}</h6>
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                    @if( isset($room_features) && count($room_features)>0)
                                                        @foreach ($room_features as $room_feature)
                                                            <p class="selectchip">{{$room_feature->features_name}}</p>
                                                        @endforeach
										             @endif 
                                                    <!-- <p class="selectchip">Hot Water <span class="closechps">×</span></p> -->
                                                </div>
                                            </div>
                                            <div class="whiteBox-w Room RoomFeaturesFacilitiesBox">
                                                <h6 class="hd6 h6">{{ __('home.RoomFacilities') }}</h6>
                                                <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                @if(isset($room_facilities) && count($room_facilities)>0)
										        	@foreach ($room_facilities as $room_facilitie)
                                                    <p class="selectchip">{{$room_facilitie->facilities_name}}</p>
                                                    @endforeach
										        @endif 
                                                </div>
                                            </div>
                                            <div class="whiteBox-w occupancyPricingDetailBox">
                                                <div class="">
                                                    <h6 class="hd6 h6">{{ __('home.OccupancyPricing') }}</h6>
                                                    <h6 class="p2 mb-3">{{ __('home.standardOccupancy') }}</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                    {{ __('home.adult') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                {{ isset($room->standard_occupancy_adult)?$room->standard_occupancy_adult:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                     {{ __('home.child') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                {{ isset($room->standard_occupancy_child)?$room->standard_occupancy_child:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="divider mb-3"></div>
                                                    <h6 class="p2 mb-3">{{ __('home.maximumOccupancy') }}</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.adult') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                {{ isset($room->maximum_occupancy_adult)?$room->maximum_occupancy_adult:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.child') }}  :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                {{ isset($room->maximum_occupancy_child)?$room->maximum_occupancy_child:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="divider mb-3"></div>
                                                    <h6 class="hd6 h6">{{ __('home.standardPrice') }} <span class="p3">({{ __('home.perNight') }})</span></h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.weekday') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    ₩ {{ isset($room->standard_price_weekday)?$room->standard_price_weekday:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.Weekend') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    ₩ {{ isset($room->standard_price_weekend)?$room->standard_price_weekend:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.peakSAeason') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    ₩ {{ isset($room->standard_price_peakseason)?$room->standard_price_peakseason:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="divider mb-3"></div>
                                                    <h6 class="hd6 h6"> {{ __('home.extraGuestFee') }}<span class="p3">(Per Night)</span></h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="policiesRow mb-3">
                                                                <div class="policiesLeftName mb-2 p2">
                                                                {{ __('home.extraGuestFeeNight') }} :
                                                                </div>
                                                                <div class="policiesLeftValue p2">
                                                                    ₩ {{ (isset($room->extra_guest_fee))?$room->extra_guest_fee:'N.A.'; }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 HotelImagesCl">
                                            <div class="whiteBox-w">
                                                <h6 class="h6 hd6">{{ __('home.roomImages') }}</h6>
                                                <div>
                                                    @if(count($room->hasImages) >0)
                                                    <div id="hotelslider" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $imgCounter1 =0;
                                                            @endphp
                                                            @foreach ($room->hasImages as $img1)
                                                            <div class="carousel-item hotelslides {{ ($imgCounter1==0)?'active':''; }}">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/room_images/'.$img1->room_image); }}" alt="" class="rootypeImage">
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
                                                        @if(count($room->hasImages) >1)
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
                                                        @foreach ($room->hasImages as $img2)
                                                        @if($imgCounter2==0)
                                                            <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="{{ $imgCounter2; }}" class="active" aria-current="true" aria-label="Slide {{ $imgCounter2; }}">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/room_images/'.$img2->room_image); }}" alt="" class="rootypeImage">
                                                            </button>
                                                            @else
                                                            <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="{{ $imgCounter2; }}" aria-label="Slide {{ $imgCounter2; }}">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/room_images/'.$img2->room_image); }}" alt="" class="rootypeImage">
                                                            </button>
                                                            @endif 
                                                            @php
                                                                $imgCounter2++;
                                                            @endphp
                                                            @endforeach 
                                                            <!-- <button type="button" data-bs-target="#hotelslider" data-bs-slide-to="2" aria-label="Slide 3">
                                                                <div class="overlay"></div>
                                                                <img src="{{asset('/assets/images/')}}/product/rootype3.png" alt="" class="rootypeImage">
                                                            </button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <!-- <button class="btn-back btnPrevious">Back</button> -->
                                    <!-- <button class="btn" data-bs-toggle="modal" data-bs-target=".thankyouDialog">Save</button> -->
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a href="{{route('room_occupancy_n_pricing',$slug )}}" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                                    <button class="btn btnNext tab form_submit" type="button" data-btntype="next">{{ __('home.Save') }}</button>
                                </div>
                                </form>
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
                            <p class="p2 mb-4">{{ __('home.yourRoomHasBeenAddedSuccessfully') }}</p>
                        </div>
                        <a href="{{ route('rooms') }}" class="btn w-100">{{ __('home.continue') }}</a>
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
<script>
    $(document).ready(function(){
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        function form_submit()
        { 
            var token=true; 
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                let formdata = $( "#room_summary_form" ).serialize();
                $.post("{{ route('room_summary_save') }}", formdata, function( data ) {
                    if(data.status==1){
                        // window.location.href = data.nextpageurl; 
                        $('.thankyouDialog').modal('show');
                        unloading();
                    } 
                    else
                    {
                        $(".form_submit").prop("disabled",false);
                        unloading();
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        setTimeout(function() {
                            $("#commonErrorBox").hide();
                        }, 3000); 
                    }                           
                    unloading();
                });             
            }
        }
    });
</script>
@endsection