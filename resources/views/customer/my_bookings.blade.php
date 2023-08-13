@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
    <!-- include left bar here -->
    @include('customer.leftbar')    
        <div class="content-box-right bookings-sec">
            <div class="container-fluid">
                @if(count($bookings) > 0)
                @foreach ($bookings as $booking) 
                @php
                    $check_in_date=date_create($booking->check_in_date);
                    $check_out_date=date_create($booking->check_out_date);
                @endphp
                <a href="{{ route('booking-detail',$booking->slug); }}">
                    <div class="whitebox-w mb-3">
                        <div class="white-card-header d-flex align-items-center flex-wrap">
                            <div>
                                <h5 class="h5">{{ $booking->hotel_name; }}</h5>
                                <p class="p3 mb-0"><span>{{ __('home.bookingID') }} : {{ $booking->slug; }}</span> <span class="dotgray"></span> <span class="text-capitalize">{{ $booking->city; }}</span> </p>
                            </div>
                            <div class="ml-auto">
                                <span class="chips chips-{{ $booking->booking_status; }} text-capitalize">{{ str_replace("_"," ",$booking->booking_status);  }}</span>
                            </div>
                        </div>
                        <div class="white-card-body">
                            <div class="bk-dtlMainRow d-flex flex-wrap">
                                <div class="bk-dtlRow d-flex flex-wrap">
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2">{{ __('home.checkIn') }}</p>
                                        <p class="p2 mb-1">{{ date_format($check_in_date,"Y-m-d") }}</p>
                                        <p class="p3">{{ __('home.checkIn') }} {{ $booking->check_in; }}</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2">{{ __('home.checkOut') }}</p>
                                        <p class="p2 mb-1">{{ date_format($check_out_date,"Y-m-d") }}</p>
                                        <p class="p3">{{ __('home.checkOut') }} {{ $booking->check_out; }}</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2">{{ __('home.room') }}</p>
                                        <p class="p2 mb-1">1 {{ __('home.room') }} x {{ $booking->no_of_nights; }} {{ __('home.nights') }}</p>
                                    </div>
                                    <div class="bk-dtlCol">
                                        <p class="p3 mb-2">{{ __('home.guests') }}</p>
                                        <p class="p2 mb-1">{{ $booking->no_of_adults + $booking->no_of_childs; }} ({{ $booking->no_of_adults; }} {{ __('home.adult') }}, {{ $booking->no_of_childs; }} {{ __('home.child') }})</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @else
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{ asset('/assets/images/') }}/structure/rewards-empty-img.png" alt="" class="empty-list-image">
                        <h6>{{ __('home.Yourbookinglistisempty') }}</h6>
                        <p class="p3 mb-4" style="color:#717972;">{{ __('home.youcanbookabutton') }}</p>
                        <a href="{{ route('home'); }}" class="btn">{{ __('home.GoforBooking') }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function() {
    });
</script>
@endsection