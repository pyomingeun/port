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
                        <form action="javaScript:Void(0);" method="post" id="room_summary_form">
                            <div class="roomsManageform-Content">
                                <h5 class="hd5 h5">{{ __('home.RoomInfoSummary') }}</h5>
                                <div class="whiteBox-w roomsSummaryDetailBox">
                                    <h5 class="hd5 h5">{{ isset($room->room_name)?$room->room_name:''; }}</h6>
                                    <div class="table-responsive table-vie tableciew1">
                                        <table class="table align-middle" style="border: none">
                                            <thead>
                                                <tr>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.RoomSize') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.NoOfBathRoom') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.Bed') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.StandardOccupancy') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.MaxOccupancy') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.StandardPrice') }} </p>
                                                    </th>
                                                    <th class="policiesLeftName p2" style="text-align: center;">
                                                        <p> {{ __('home.ExtraGuestFee') }} </p>
                                                    </th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">{{ $room->room_size}} m<sup>2</sup></td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">{{ $room->no_of_bathrooms }} </td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">
                                                        @foreach ($room->hasbeds as $bed)
                                                            {{ $bed->bed_type }} : {{ $bed->bed_qty }} 개<br>
                                                        @endforeach
                                                    </td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">
                                                        {{ __('home.NoOfGuest') }}: {{$room->standard_occupancy_adult}} <br>
                                                        {{ __('home.ChildBelow3') }}: {{$room->standard_occupancy_child}}
                                                    </td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">
                                                        {{ __('home.NoOfGuest') }}: {{$room->maximum_occupancy_adult}} <br>
                                                        {{ __('home.ChildBelow3') }}: {{$room->maximum_occupancy_child}}
                                                    </td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;">
                                                        {{ __('home.Weekday') }}: {{number_format($room->standard_price_weekday)}}원<br>
                                                        {{ __('home.Weekend') }}: {{number_format($room->standard_price_weekend)}}원<br>
                                                        {{ __('home.PeakSeason') }}: {{number_format($room->standard_price_peakseason)}}원
                                                    </td>
                                                    <td class="policiesLeftValue p2" style="text-align: center;"> {{number_format($room->extra_guest_fee)}}원</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="policiesLeftName p2"> {{ __('home.RoomAmenity') }} : 
                                            @if(count($room_facilities))
                                                @foreach ($room_facilities as $facility)
                                                    {{ $facility->facilities_name }}, 
                                                @endforeach
                                            @else
                                                {{ __('home.NoContents') }}   
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="whiteBox-w roomsSummaryDetailBox">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h5 class="hd6 h6">{{ __('home.RoomDescription') }} </h>
                                        <p class="policiesLeftName p2">
                                            @if($room->room_description !='')
                                                {!! $room->room_description; !!}
                                            @else
                                                {{ __('home.NoContents') }}
                                            @endif 
                                        </p>
                                    </div>
                                </div>
                                <div class="whiteBox-w RoomImagesList" id="RoomImageList">
                                    <h6 class="h6 hd6">{{ __('home.RoomImage') }}</h6>
                                    <div class="hotelImagesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection">
                                        @if(count($room->hasImages) >0)
                                            @foreach ($room->hasImages as $image)
                                                <div class="hotelImgaesPreviewCol" id="room_img_{{$image->id}}">
                                                    <div class="RoomImageOverlay"></div>
                                                        <img src="{{ asset('/room_images/'.$image->room_image); }}" alt="N.A." class="hotelPreviewImage">
                                                    </div>
                                            @endforeach
                                        @else 
                                            {{ __('home.NoContents') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a href="{{route('room_occupancy_n_pricing',$slug )}}" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                                    <button class="btn btnNext tab form_submit" type="button" data-btntype="next">{{ __('home.Save') }}</button>
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
                        <p class="p2 mb-4">{{ __('home.yourRoomHasBeenAddedSuccessfully') }}</p>
                    </div>
                    <a href="{{ route('rooms') }}" class="btn w-100">{{ __('home.continue') }}</a>
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