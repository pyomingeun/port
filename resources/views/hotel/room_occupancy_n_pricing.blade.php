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
                                <form action="javaScript:Void(0);" method="post" id="room_onp_form">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt StandardOccupancyBox">
                                            <h5 class="hd5 h5">{{ __('home.standardOccupancy') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="quantity-row row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.adult') }}<span class="required-star">*</span></p>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                            <div class="quantity-box d-flex align-items-center ml-auto" id="standard_occupancy_adult_validate">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" id="standard_occupancy_adult"  name="standard_occupancy_adult" value="{{ isset($room->standard_occupancy_adult)?$room->standard_occupancy_adult:'1'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <p class="error-inp" id="standard_occupancy_adult_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="quantity-row row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.child') }}<span class="required-star">*</span></p>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                            <div class="quantity-box d-flex align-items-center ml-auto" id="standard_occupancy_child_validate">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" id="standard_occupancy_child"  name="standard_occupancy_child" value="{{ isset($room->standard_occupancy_child)?$room->standard_occupancy_child:'1'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <p class="error-inp" id="standard_occupancy_child_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt MaximumOccupancyBox">
                                            <h5 class="hd5 h5"></h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="quantity-row row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.adult') }}<span class="required-star">*</span></p>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                            <div class="quantity-box d-flex align-items-center ml-auto" id="maximum_occupancy_adult_validate">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" id="maximum_occupancy_adult"  name="maximum_occupancy_adult" value="{{ isset($room->maximum_occupancy_adult)?$room->maximum_occupancy_adult:'1'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <p class="error-inp" id="maximum_occupancy_adult_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="quantity-row row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.child') }}<span class="required-star">*</span></p>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                            <div class="quantity-box d-flex align-items-center ml-auto" id="maximum_occupancy_child_validate">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" id="maximum_occupancy_child"  name="maximum_occupancy_child" value="{{ isset($room->maximum_occupancy_child)?$room->maximum_occupancy_child:'1'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <p class="error-inp" id="maximum_occupancy_child_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt StandardPricBox">
                                            <h5 class="hd5 h5">{{ __('home.standardPrice') }} <span class="p2">{{ __('home.perNight') }})</span></h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 standrdPriceCol">
                                                    <div class="d-flex align-items-center">
                                                        <p class="p2 mb-0">{{ __('home.weekday') }} <img src="{{asset('/assets/images/')}}/structure/info-gray.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox'> <span class='normalfont'>Sun</span>, <span class='normalfont'>Mon</span>, <span class='normalfont'>Tue</span>, <span class='normalfont'>Wed</span>, <span class='normalfont'>Thu</span> </div>"></p>
                                                        <div class="InpCol" id="standard_price_weekday_validate">
                                                            <div class="input-group inpWtCaption-Rt">
                                                                <input type="text" class="form-control" placeholder="" id="standard_price_weekday"  name="standard_price_weekday" value="{{ isset($room->standard_price_weekday)?$room->standard_price_weekday:''; }}">
                                                                <span class="input-group-text" id="basic-addon2">₩</span>
                                                            </div>
                                                            <p class="error-inp" id="standard_price_weekday_err_msg"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 standrdPriceCol">
                                                    <div class="d-flex align-items-center">
                                                        <p class="p2 mb-0">{{ __('home.Weekend') }} <img src="{{asset('/assets/images/')}}/structure/info-gray.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox tooltipboxSm'> <span class='normalfont'>Fri</span>, <span class='normalfont'>Sat</span> </div>"></p>
                                                        <div class="InpCol">
                                                            <div class="input-group inpWtCaption-Rt"  id="standard_price_weekend_validate">
                                                                <input type="text" class="form-control" placeholder="" id="standard_price_weekend"  name="standard_price_weekend" value="{{ isset($room->standard_price_weekend)?$room->standard_price_weekend:''; }}">
                                                                <span class="input-group-text" id="basic-addon2">₩</span>
                                                                <p class="error-inp" id="standard_price_weekend_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 standrdPriceCol">
                                                    <div class="d-flex align-items-center">
                                                        <p class="p2 mb-0">{{ __('home.peakSAeason') }} <img src="{{asset('/assets/images/')}}/structure/info-gray.svg" alt="" class="infoIcon" style="margin-bottom: 2px;" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $hotel_peak_season }}"></p>
                                                        <div class="InpCol">
                                                            <div class="input-group inpWtCaption-Rt" id="standard_price_peakseason_validate">
                                                                <input type="text" class="form-control" placeholder="" id="standard_price_peakseason"  name="standard_price_peakseason" value="{{ isset($room->standard_price_peakseason)?$room->standard_price_peakseason:''; }}">
                                                                <span class="input-group-text" id="basic-addon2">₩</span>
                                                                <p class="error-inp" id="standard_price_peakseason_err_msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt ExtraGuestFeeBox">
                                            <h5 class="hd5 h5 mb-2">{{ __('home.extraGuestFee') }} <span class="p2">({{ __('home.perNight') }})</span></h5>
                                            <p class="p3 mb-4">{{ __('home.extraFeeIsExemptedForChildrenUnder') }}</p>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="inpWtTextRtbg d-flex">
                                                        <div class="form-floating" id="extra_guest_fee_validate">
                                                            <input type="text" class="form-control" id="extra_guest_fee" autocomplete="off" placeholder="{{ __('home.extraGuestFee') }}/{{ __('home.Night') }}" name="extra_guest_fee" value="{{ (isset($room->extra_guest_fee))?$room->extra_guest_fee:''; }}">
                                                            <label for="extra_guest_fee">{{ __('home.extraGuestFee') }}/{{ __('home.Night') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="extra_guest_fee_err_msg"></p>
                                                        </div>
                                                        <span class="inpTextRtbg">₩</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a href="{{route('room_features_n_facilities',$slug )}}" class="btn-back btnPrevious">Back</a>
                                    <a class="btn bg-gray1" href="{{ route('rooms') }}">Cancel</a>
                                    <button class="btn outline-blue form_submit" type="button" data-btntype="save_n_exit" >Save & Exit</button>
                                    <button class="btn btnNext tab4  form_submit" type="button" data-btntype="next">Next</button>
                                </div>
                                </form>
                            </div>
                        </div>
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
                let formdata = $( "#room_onp_form" ).serialize();
                $.post("{{ route('room_occupancy_n_pricing_submit') }}", formdata, function( data ) {
                    if(data.status==1){
                        window.location.href = data.nextpageurl; 
                        unloading();
                    } 
                    else
                    {
                        $(".form_submit").prop("disabled",false); 
                    }                           
                    unloading();
                });             
            }
        }
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection