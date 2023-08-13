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
                            <div class="hotelManageform-Content">
                                    <h5 class="hd5 h5">{{ __('home.HotelInfoSummary') }}</h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="whiteBox-w SummaryDetailBox">
                                            <div class="row ">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="summeryattDetailRow d-flex align-items-center">
                                                            <div class="summeryHtlimageBox">
                                                                <img src="{{asset('/hotel_logo/'.$hotel->logo); }}" alt="" class="summeryHtlimage" style="display:{{($hotel->logo !='' )?'block':'none'; }}">
                                                                <img src="{{asset('/assets/images/')}}/structure/photo.png" alt="" class="summeryHtlimage" style="display:{{($hotel->logo =='' )?'block':'none'; }}">
                                                            </div>
                                                            <div class="summeryDetailDes">
                                                                <p class="p1 mb-1">{{ $hotel->hotel_name}}</p>
                                                                <p class="p3 mb-0">{{ $hotel->formatted_address }} </p>
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
                                                    <div class="attdetailRow d-flex flex-wrap mb-3">
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
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">{{ __('home.NoContents') }}</div>
                                            </div>                
                                            @endif
                                        </div>
                                        </div>
                                        <div class="whiteBox-w policiesHtlDetailBox">
                                        <div class="">
                                            <h6 class="hd6 h6">{{ __('home.HotelPolicy') }}</h6>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="policiesRow d-flex flex-wrap mb-3">
                                                        <div class="policiesLeftName p2">{{ __('home.CheckIn') }} {{ __('home.Time') }} :</div>
                                                        @if($hotel->check_in !='')
                                                            <div class="policiesLeftValue p2">{{ $hotel->check_in }} </div>
                                                        @else
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">{{ __('home.NoContents') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="policiesRow d-flex flex-wrap mb-3">
                                                        <div class="policiesLeftName p2">{{ __('home.CheckOut') }} {{ __('home.Time') }} :</div>
                                                        @if($hotel->check_out !='')
                                                            <div class="policiesLeftValue p2">{{ $hotel->check_out }}</div>
                                                        @else
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">{{ __('home.NoContents') }}</div>
                                                        @endif    
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="policiesRow d-flex flex-wrap mb-3">
                                                        <div class="policiesLeftValue p2">
                                                            @if($hotel->hotel_policy !='')
                                                                <div class="policiesLeftValue p2">{!! $hotel->hotel_policy; !!} </div>
                                                            @else
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">{{ __('home.NoContents') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="whiteBox-w cancelpoliciesHtlDetailBox">
                                        <h6 class="hd6 h6 mb-4">{{ __('home.CancellationPolicy') }}</h6>
                                        <div class="row">
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">{{ __('home.TheDay') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->same_day_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0"> 1{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_1day_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">2{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_2days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">3{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_3days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">4{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_4days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">5{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_5days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">6{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_6days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">7{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_7days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">8{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_8days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">9{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_9days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cancellationPolicycnt-Row d-flex align-items-center">
                                                <div class="circleBefor"></div>
                                                <div class="cancellationPolicycnt d-flex align-items-center">
                                                    <span class="bgpink"></span>
                                                    <div class="cancellationPolicyCol1">
                                                        <p class="p2 mb-0">10{{ __('home.Day') }}{{ __('home.Before') }} {{ __('home.Cancel') }}</p>
                                                    </div>
                                                    <div class="cancellationPolicyCol2 d-flex align-items-center">
                                                        <p class="p2 mb-0"><span class="cpPercent">{{ $hotel->b4_10days_refund}}%</span> {{ __('home.Refund') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        @php /*
                                        <div class="whiteBox-w termsConditionHtlDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.TermsandConditionsg') }}</h6>

                                            @if($hotel->terms_and_conditions !='')
                                                {!! $hotel->terms_and_conditions; !!}
                                            @else
                                                {{ __('home.NoContents') }}
                                            @endif    
                                        </p>
                                        </div> */
                                        @endphp
                                        <div class="whiteBox-w hotelFeaturesHtlDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.HotelFeature') }}</h6>
                                        @if(count($hotel_features) >0)
                                            <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                @foreach ($hotel_features as $hotel_feature)    
                                                    <p class="selectchip">{{$hotel_feature->feature_name}}</p>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="selectedTabsRw d-flex flex-wrap align-items-center" style="font-size: 14px;">{{ __('home.NoContents') }}</div>
                                        @endif
                                        </div>
                                        <div class="whiteBox-w hotelFacilitiesHtlDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.HotelFacility') }}</h6>
                                        @if(count($hotel_facilities) >0)
                                            <div class="selectedTabsRw d-flex flex-wrap align-items-center">
                                                @foreach ($hotel_facilities as $facilitie)
                                                    <p class="selectchip">{{$facilitie->facility_name}} </p>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="selectedTabsRw d-flex flex-wrap align-items-center" style="font-size: 14px;">{{ __('home.NoContents') }}</div> 
                                        @endif                                               
                                        </div>
                                        <div class="whiteBox-w extraServiceHtlDetailBox">
                                        <h6 class="hd6 h6"> {{ __('home.ExtraService') }}</h6>    
                                        @if(count($hotel->hasExtraServices) >0)
                                            <div class="table-responsive table-vie tableciew1">
                                                <table class="table align-middle" style="border: none">
                                                    <thead>
                                                        <tr>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.ServiceName') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.UnitPrice') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.MaxQty') }} </p>
                                                            </th>
                                                        </tr>
                                                    </thead>                                                        
                                                    <tbody>
                                                        @foreach ($hotel->hasExtraServices as $es)
                                                            <tr>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{$es->es_name}}</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{number_format($es->es_price)}}원</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{$es->es_max_qty}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="font-size: 14px;"> {{ __('home.NoContents') }} </div>
                                            </div>                                             
                                        @endif   
                                        </div>
                                        <div class="whiteBox-w extraServiceHtlDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.LongStayDiscount') }} </h6>
                                        @if(count($hotel->hasLongStayDiscount) >0)
                                            <div class="table-responsive table-vie tableciew1">
                                                <table class="table align-middle" style="border: none">
                                                    <thead>
                                                        <tr>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.MinDayStay') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.MaxDayStay') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.Discount') }} </p>
                                                            </th>
                                                        </tr>
                                                    </thead>                                                        
                                                    <tbody>
                                                        @foreach ($hotel->hasLongStayDiscount as $lsd)
                                                            <tr>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{$lsd->lsd_min_days}}{{ __('home.Day') }}</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{$lsd->lsd_max_days}}{{ __('home.Day') }}</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">
                                                                    @if($lsd->lsd_discount_type =='percentage')
                                                                        {{ $lsd->lsd_discount_amount}}%
                                                                    @else
                                                                        ₩ {{ $lsd->lsd_discount_amount}}
                                                                    @endif 
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="font-size: 14px;"> {{ __('home.NoContents') }} </div>
                                            </div>                                             
                                        @endif   
                                        </div>
                                        <div class="whiteBox-w extraServiceHtlDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.PeakSeason') }}</h6>
                                        @if(count($hotel->hasPeakSeasont) >0)
                                            <div class="table-responsive table-vie tableciew1">
                                                <table class="table align-middle" style="border: none">
                                                    <thead>
                                                        <tr>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.SeasonName') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.StartDate') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.EndDate') }} </p>
                                                            </th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        @foreach ($hotel->hasPeakSeasont as $ps)
                                                            @php
                                                                $sdate=date_create($ps->start_date);
                                                                $edate=date_create($ps->end_date);
                                                            @endphp
                                                            <tr>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{$ps->season_name}}</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{  date_format($sdate,"Y-m-d") }}</td>
                                                                <td class="policiesLeftValue p2" style="text-align: center;">{{  date_format($edate,"Y-m-d") }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="font-size: 14px;"> {{ __('home.NoContents') }} </div>
                                            </div>                                             
                                        @endif   
                                        </div>

                                        <div class="whiteBox-w BankDetailbox" id="BankDetailBox">
                                        <h6 class="hd6 h6">{{ __('home.BankDetails') }}</h6>
                                        @if(isset($hotel->hasHotelBankAcDetails->account_num) && $hotel->hasHotelBankAcDetails->account_num !='')
                                            <div class="table-responsive table-vie tableciew1">
                                                <table class="table align-middle" style="border: none">
                                                    <thead>
                                                        <tr>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.BankName') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.AccountNo') }} </p>
                                                            </th>
                                                            <th class="policiesLeftName p2" style="text-align: center;">
                                                                <p> {{ __('home.AccountHolder') }} </p>
                                                            </th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                      <tr>
                                                        <td class="policiesLeftValue p2" style="text-align: center;">{{ $hotel->hasHotelBankAcDetails->bank_name }}</td>
                                                        <td class="policiesLeftValue p2" style="text-align: center;">{{ $hotel->hasHotelBankAcDetails->account_num }}</td>
                                                        <td class="policiesLeftValue p2" style="text-align: center;">{{ $hotel->hasHotelBankAcDetails->ac_holder_name }} </td>
                                                      </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="font-size: 14px;"> {{ __('home.NoContents') }} </div>
                                            </div>                                             
                                        @endif   
                                        </div>
                                        </div>
                                        <div class="whiteBox-w BankDetailbox" id="BankDetailBox">
                                            <h6 class="h6 hd6">{{ __('home.HotelImages') }}</h6>
                                            <div class="hotelImagesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection">
                                                @foreach ($hotel->hasImage as $image)
                                                    <div class="hotelImgaesPreviewCol" id="hotel_img_{{$image->id}}">
                                                        <i class="markfeaturedhmimg {{ ($image->is_featured==1)?'fa fa-star favStar favStar-fill':'fa fa-star-o favStar favStar-outline'; }} " data-i="{{$image->id}}" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>" id="featured_icon_{{$image->id}}"></i>
                                                        <img src="{{ asset('/hotel_images/'.$image->image); }}" alt="N.A." class="img-thumbnail">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                                            <a href="{{route('hm_otherInfo',$hotel->hotel_id)}}" class="btn-back btnPrevious">Back</a>
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                            <input type="hidden" value="next" name="savetype" id="savetype">
                                            <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                            <button type="button" class="btn btnNext tab3 form_submit" data-btntype="next">{{ __('home.HotelConfigComplete') }}</button>
                                        </div>
                                    </div>
                            </div>
                        </form>
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
                        <p class="p2 mb-4">{{ __('home.HotelInfoRegistered') }}</p>
                        <p class="p2 mb-4">{{ __('home.RegisterRooms') }}</p>
                    </div>
                    <a href="{{route('rooms'); }}" class="btn w-100">{{ __('home.Continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- common models -->
@include('common_modal')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script src="//cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<script>
$(document).ready(function() {
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
             
                if (percent == 100) {
                   $(this).siblings('.prog-des').find('h6').text("{{ __('home.CompletedProfile') }}");
                }
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