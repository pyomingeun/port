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
        <div class="content-box-right dashboard1-sec">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 dashboard1-col-left">
                        <div class="hotel-image-ds-box">
                            <img src="{{asset('/assets/images/')}}/structure/hotel.png" alt="" class="hotel-image-ds">
                        </div>
                        <div class="whitebox-w">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-8 col-12">
                                    <h6 class="h6 hg6">{{ __('home.viewCreateBookings') }}</h6>
                                    <p class="p2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-4 col-12 d-flex align-items-center justify-content-end">
                                     @if(auth()->user()->access != 'admin')
                                    <a href="{{ route('rooms'); }}" class="btn outline-blue">{{ __('home.createBooking') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="whitebox-w">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-8 col-12">
                                    <h6 class="h6 hg6">{{ __('home.manageRooms') }}</h6>
                                    <p class="p2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-4 col-12 d-flex align-items-center justify-content-end">
                                @if(auth()->user()->access != 'admin')
                                    <a href="{{ route('rooms'); }}" class="btn outline-blue01">{{ __('home.manageRoom') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="whitebox-w">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-8 col-12">
                                    <h6 class="h6 hg6">{{ __('home.checkYourInbox') }}</h6>
                                    <p class="p2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-4 col-12 d-flex align-items-center justify-content-end">
                                @if(auth()->user()->access != 'admin')
                                    <a href="{{ route('rooms'); }}" class="btn outline-blue">{{ __('home.chat') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->access != 'admin')
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 dashboard1-col-right">
                        <div class="managheHotelBoxRight">
                            <div class="text-center">
                                <div class="hotelManageImgBox">
                                    @if($hotel && $hotel->logo != null) 
                                        <img src="{{ asset('/hotel_logo/'.$hotel->logo) }}" alt="" class="hotelLogo">
                                    @else
                                        <img src="{{ asset('/assets/images/structure/hotel_default.png') }}" alt="" class="hotelLogo">
                                    @endif                               
                                </div>
                                <h5 class="h5 mb-4">{{ (isset($hotel->hotel_name))?$hotel->hotel_name:''; }}</h5>
                                <div class="divider mb-4" style="background-color: #EEF5EE;"></div>
                                <p class="p2"><img src="{{asset('/assets/images/')}}/structure/location-on.svg" alt="" class="addressIcon">
                                    @if($hotel)
                                        {{ $hotel->street }}{{ ($hotel->city !='' && $hotel->street !='')?', ':''; }} 
                                        {{ $hotel->city }}{{ ($hotel->city !='' && $hotel->subrub !='')?', ':''; }}
                                        {{ $hotel->subrub }} {{ ($hotel->pincode !='')?' - ':''; }}{{ $hotel->pincode }}
                                    @endif
                                </p>
                                <p class="p2 mb-0"><img src="{{asset('/assets/images/')}}/structure/clock.svg" alt="" class="addressIcon"> 
                                    @if($hotel)
                                        {{$hotel->check_in}} - {{$hotel->check_out}}
                                    @endif    
                                </p>
                                <div class="mt-5">
                                    @if($hotel)
                                        <a href="{{ route('hm_basic_info',$hotel->hotel_id); }}" class="btn">{{ __('home.ManageHotel') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif 
                </div>
            </div>
        </div>
    </div>
<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection