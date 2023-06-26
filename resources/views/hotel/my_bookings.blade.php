@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right bookings-sec my-booking-hotel-manager">
            <div class="container-fluid">
                @php
                /* 
                <div class="heading-sec mb-4 d-flex flex-wrap align-items-center">
                    <h5 class="h5  mb-2">{{ __('home.BookingManagement') }}</h5>
                    <div class="filter-header-row ml-auto d-flex justify-content-end mb-2">
                        <div class="filter-header-col searchFilBox">
                            <img src="{{asset('/assets/images/')}}/structure/search-gray.svg" alt="" class="searchIcon" />
                            <input type="text" class="form-control" placeholder="Search by guest name and phone number" value="" />
                        </div>
                        <div class="filter-header-col d-flex align-items-center doubleDatpickerBox">
                            <img src="{{asset('/assets/images/')}}/structure/calendar.svg" alt="" class="calendarIcon" />
                            <input type="text" class="form-control checjincheckout" placeholder="" value="2022/09/06" />
                        </div>
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                        <a href="{{ route('create-booking'); }}" class="btn h-36">{{ __('home.createBooking') }}</a>
                        </div>
                    </div>
                </div>
                */ 
                @endphp
                @foreach ($bookings as $booking)
                @php
                    $check_in_date=date_create($booking->check_in_date);
                    $check_out_date=date_create($booking->check_out_date);
                @endphp
                <a href="{{ route('booking-detail',$booking->slug); }}">
                    <div class="whitebox-w mb-3">
                        <div class="white-card-header d-flex align-items-center flex-wrap">
                            <div>
                                <h5 class="h5">{{ $booking->customer_full_name; }}<span class="vertLine">|</span> {{ $booking->customer_phone; }}</h5>
                                <p class="p3 mb-0"><span>bookingID : {{ $booking->slug; }}</span> <span class="dotgray"></span> <span>{{ $booking->customer_email; }}</span> </p>
                            </div>
                            <div class="ml-auto">
                            <span class="chips chips-{{ $booking->booking_status; }} text-capitalize">{{ str_replace("_"," ",$booking->booking_status);  }}</span>
                            </div>
                        </div>
                        <div class="white-card-body">
                            <div class="bk-dtlMainRow d-flex flex-wrap">
                                <div class="bk-dtlRow d-flex flex-wrap">
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2"> {{ __('home.checkIn') }}</p>
                                        <p class="p2 mb-1">{{ date_format($check_in_date,"Y-m-d") }}</p>
                                        <p class="p3">{{ __('home.checkIn') }} {{ $booking->check_in; }}</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2"> {{ __('home.checkOut') }}</p>
                                        <p class="p2 mb-1">{{ date_format($check_out_date,"Y-m-d") }}</p>
                                        <p class="p3">{{ __('home.checkOut') }}  {{ $booking->check_out; }}</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2"> {{ __('home.room') }}</p>
                                        <p class="p2 mb-1">{{ $booking->room_name; }} (1 {{ __('home.room') }} x {{ $booking->no_of_nights; }} {{ __('home.Nights') }})</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2"> {{ __('home.guests') }}</p>
                                        <p class="p2 mb-1">{{ $booking->no_of_adults + $booking->no_of_childs; }} ({{ $booking->no_of_adults; }} Adult, {{ $booking->no_of_childs; }} {{ __('home.child') }})</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2"> {{ __('home.price') }}</p>
                                        <p class="p2 mb-1 priceBlue">₩ {{ ((((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount)+$booking->extra_services_charges }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    <!--Delete Modal -->
    <div class="modal fade deleteDialog deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3 mt-2"> {{ __('home.deleteAccount') }}</h3>
                        <p class="p2 mb-4">{{ __('home.areYouSureYouWantToDeleteYourAccount') }}</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill" data-bs-dismiss="modal">{{ __('home.yes') }}</button>
                        <button class="btn flex-fill" data-bs-dismiss="modal">{{ __('home.no') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Change password Modal -->
    <div class="modal fade changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3">{{ __('home.changePassword') }}</h3>
                        <p class="p2">{{ __('home.setYourNewPasswordWithEnter') }}</p>
                    </div>
                    <form action="post">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="oldPassword" placeholder="{{ __('home.password') }}">
                            <label for="oldPassword">{{ __('home.oldPasswordroomType') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/')}}/structure/eye-icon.svg" alt="eye-icon" class="eye-icon" />
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="newPassword" placeholder="{{ __('home.password') }}">
                            <label for="newPassword">{{ __('home.newPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/')}}/structure/eye-icon-hide.svg" alt="eye-icon" class="eye-icon" />
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="{{ __('home.password') }}">
                            <label for="confirmPassword">{{ __('home.confirmPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/')}}/structure/eye-icon-hide.svg" alt="eye-icon" class="eye-icon" />
                        </div>
                        <div class="row password-instruction">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-green.svg" alt="Check" class="passInsIcon" />{{ __('home.oneLowercaseCharacter') }}
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-green.svg" alt="Check" class="passInsIcon" />{{ __('home.oneSpecialCharacter') }}
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />{{ __('home.oneUppercaseCharacter') }}
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />8 {{ __('home.charactersMinimum') }}
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />{{ __('home.passwordsMatch') }}
                                </p>
                            </div>
                        </div>
                        <button type="button" class="btn w-100 mt-3 mb-2">{{ __('home.Save') }}</button>
                    </form>
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
    $(document).ready(function() {
    });
</script>
@endsection