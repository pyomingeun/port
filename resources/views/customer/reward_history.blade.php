@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
<!-- include left bar here -->
        @include('customer.leftbar')
        <div class="content-box-right my-rewards-sec">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-12 col-md-4 col-md-12 col-sm-4 col-12 rewards-main-block">
                        <div class="rewards-inner-block">
                            <p class="p3">{{ __('home.rewards') }}</p>
                            <div class="d-flex align-items-center">
                                <img src="{{asset('/assets/images/')}}/structure/stars-circle-blue.svg" alt="" class="m-r-rewalrdIcon">
                                <div>
                                    <h3 class="h3">{{ auth()->user()->total_rewards_points }}</h3>
                                    <p class="p2">{{ __('home.TotalRewardEarn') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-8 col-md-12 col-sm-8 col-12 grab-rewards-hotel-booking">
                        <div class="grab-rewards-hotel-booking-inner-box d-flex align-items-center">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-md-12 col-sm-3 col-12 d-flex align-items-center">
                                    <div>
                                        <h6>{{ __('home.Grabrewardsonevery') }}</h6>
                                        <h3 class="mb-0">{{ __('home.Hotel') }} {{ __('home.booking') }}</h3>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-md-12 col-sm-3 col-12">
                                    <div class="m-r-bookHotel">
                                        <h6 class="d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/hotel.svg" alt="" class="bookHotelIcon">{{ __('home.BookHotel') }}</h6>
                                        <p class="p3 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etia</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-md-12 col-sm-3 col-12">
                                    <div class="m-r-earnreward">
                                        <h6 class="d-flex align-items-center"><img src="{{asset('/assets/images/')}}/structure/stars-circle.svg" alt="" class="bookHotelIcon"> {{ __('home.EarnReward') }}</h6>
                                        <p class="p3 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($rewards) ==0)
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/rewards-empty-img.png" alt="" class="empty-list-image">
                        <h6>{{ __('home.emptylist') }}</h6>
                        <p class="p3">{{ __('home.Bookhotelandearnmanyrewardspointsforyourfuturebookings') }}</p>
                    </div>
                </div>
                @else
                <div class="whitebox-w rewardHistorybox-w mt-4">
                    <h6 class="h6">{{ __('home.RewardHistory') }}</h6>
                    @php
                    $tmpDate ='';
                    $tmpDate2 ='';
                    $rewardsCounter = count($rewards);  
                    @endphp
                    @for($i=0; $i<$rewardsCounter; $i++)
                        @if($tmpDate != $rewards[$i]->transaction_on)
                        <div class="rewardHistorybox">
                        <p class="p3">{{ $rewards[$i]->transaction_on }}</p>
                        @endif
                        @php
                        $tmpDate = $rewards[$i]->transaction_on;
                        $tmpDate2 = (isset($rewards[$i+1]->transaction_on))?$rewards[$i+1]->transaction_on:'';
                        @endphp
                            <div class="row">
                                <div class="col-xl-9 col-lg-9 col-md-9 col-md-9 col-sm-9 col-12">
                                    <div class="rewardHistoryIcnNmBox">
                                        <img src="{{asset('/assets/images/')}}/structure/points-{{ $rewards[$i]->reward_type }}.svg" class="rewHisIcon">
                                        <div>
                                            <h6 class="h6">{{ $rewards[$i]->title }}</h6>
                                            <p class="p3 mb-0">{{ $rewards[$i]->message }}<span> {{ ($rewards[$i]->booking_slug !='')?"{".$rewards[$i]->booking_slug."}":'';  }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-sm-3 col-12">
                                    <p class="p1 points-{{ $rewards[$i]->reward_type }}">{{ ($rewards[$i]->reward_type =='credited')?'+':'-'; }} {{ $rewards[$i]->reward_points }}  {{ __('home.points') }}</p>
                                </div>
                            </div>
                        @if($tmpDate != $tmpDate2)
                        </div>
                        @endif
                    @endfor
                </div>
                @endif
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