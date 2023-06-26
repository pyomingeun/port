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
                                <form action="javaScript:Void(0);" method="post" id="room_bedsinfo_form">
                                <div class="roomsManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotemmanageFormInrcnt NoofBathroomsBox">
                                            <h5 class="hd5 h5">{{ __('home.noOfBathrooms') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-6 col-12">
                                                    <div class="quantity-row row">
                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12 d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.noOfBathrooms') }}<span class="required-star">*</span></p>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div class="quantity-box d-flex align-items-center ml-auto">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" class="form-control only_integer rightClickDisabled"  id="no_of_bathrooms"  name="no_of_bathrooms" value="{{ isset($room->no_of_bathrooms)?$room->no_of_bathrooms:'1'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="d-flex align-items-center">
                                            <h5 class="h5 mb-0">{{ __('home.beds') }}</h5>
                                            <p class="p2 mb-0 addAttBtn ml-auto cursor-p addBedBtn addNewBed"><img src="{{asset('/assets/images/')}}/structure/add-circle.svg" alt="" class="add-circle"> {{ __('home.AddBed') }}</p>
                                        </div>
                                        <div class=" d-hide mt-4" id="beds_list">
                                            @if(isset($room->hasBeds) && count($room->hasBeds) >0)
                                                @foreach ($room->hasBeds as $bed)
                                                <div class="row mb-4" id="beddb_{{ $bed->id}}">
                                                    <div class="col-xl-7 col-lg-5 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating mb-0">
                                                            <input type="text" class="form-control" autocomplete="off"  placeholder="Bed Type" value="{{ $bed->bed_type}}" name="bed_type[]" id="bed_type_db_{{ $bed->id }}">
                                                            <label for="bed_type_db_{{ $bed->id }}">Bed Type<span class="required-star">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-5 col-md-10 col-sm-12 col-10 d-flex align-items-center">
                                                        <div class="quantity-row d-flex align-items-center">
                                                            <p class="p2 mb-0">{{ __('home.quantity') }}<span class="required-star">*</span> &nbsp;</p>
                                                            <div class="quantity-box d-flex align-items-center ml-auto">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" value="{{ $bed->bed_qty}}" name="bed_qty[]" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-12 col-2 d-flex align-items-center justify-content-end">
                                                        <img src="{{asset('/assets/images/')}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delbeddb" data-i="{{ $bed->id}}">
                                                    </div>
                                                    <input type="hidden" name="rid[]" value="{{$bed->id}}">
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a href="{{route('room_basic_info',$slug )}}" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                                    <a class="btn bg-gray1" href="{{ route('rooms') }}">Cancel</a>
                                    <button class="btn outline-blue form_submit" type="button" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                    <!-- <button class="btn bg-gray1">Cancel</button> -->
                                    <button class="btn btnNext tab2  form_submit" type="button" data-btntype="next">{{ __('home.Next') }}</button>
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
        var bedCounter =1;
        $(document).on('click','.addNewBed',function(){
            $('#beds_list').prepend('<div class="row mb-4" id="bednew_'+bedCounter+'"> <div class="col-xl-7 col-lg-5 col-md-12 col-sm-12 col-12"> <div class="form-floating mb-0"> <input type="text" class="form-control" autocomplete="off" placeholder="Bed Type" value="" name="bed_type[]" id="bed_type_db_'+bedCounter+'"> <label for="bed_type_db_'+bedCounter+'">Bed Type<span class="required-star">*</span></label> </div> </div> <div class="col-xl-4 col-lg-5 col-md-10 col-sm-12 col-10 d-flex align-items-center"> <div class="quantity-row d-flex align-items-center"> <p class="p2 mb-0">Quantity<span class="required-star">*</span>  </p> <div class="quantity-box d-flex align-items-center ml-auto"> <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span> <input type="text" value="1" name="bed_qty[]" /> <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span> </div> </div> </div> <div class="col-xl-1 col-lg-2 col-md-2 col-sm-12 col-2 d-flex align-items-center justify-content-end"> <img src="{{asset("/assets/images/")}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delbed" data-i="'+bedCounter+'"> </div> <input type="hidden" name="rid[]" value="0"></div></div>');
            bedCounter++;
        });
        // Remove bed new box
        $(document).on('click','.delbed',function(){
            // console.log('delete_nta');
            var i = $(this).attr('data-i');
            // console.log(i);    
            $("#bednew_"+i).remove();            
        }); 
        // del bed from db    
        $(document).on('click','.delbeddb',function(){
            // delNTA
            var i = $(this).attr('data-i');
            $("#beddb_"+i).remove();
            $.post("{{ route('delBed') }}",{_token:"{{ csrf_token() }}",r:"{{ (isset($room->id))?$room->id:0 }}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#beddb_"+i).remove();    
                    $("#commonSuccessMsg").text(data.message);
                    $("#commonSuccessBox").css('display','block');
                    setTimeout(function() {
                        $("#commonSuccessBox").hide();
                    }, 3000);
                    unloading();
                }
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 3000);
                }
            });
        });
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
                let formdata = $( "#room_bedsinfo_form" ).serialize();
                $.post("{{ route('room_beds_info_submit') }}", formdata, function( data ) {
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
@endsection