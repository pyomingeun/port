@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/scss/fullcalender.css') }}" />
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right profile-sec">
            <div class="container-fluid">
                <div class="tableboxpadding0 roomCalenderBox">
                    <button class="btn h-36 blockRoomBtn" data-bs-toggle="modal" data-bs-target=".sideFilterDialog">Block Room</button>
                    <div class="calenderStatusRw d-flex justify-content-end">
                        <p class="p3 mb-0"><span class="statusCl statusBlue"></span> {{ __('home.Available') }} </p>
                        <p class="p3 mb-0"><span class="statusCl statusOrange"></span> {{ __('home.Onhold') }} </p>
                        <p class="p3 mb-0"><span class="statusCl statusConfirmed"></span> {{ __('home.Confirmed') }} </p>
                        <p class="p3 mb-0"><span class="statusCl statusGreen"></span> {{ __('home.Completed') }} </p>
                        <p class="p3 mb-0"><span class="statusCl statusRed"></span> {{ __('home.Blocked') }} </p>
                    </div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter modeal -->
    <div class="modal fade sideFilterDialog roomcalenderSidefilter" tabindex="-1" aria-labelledby="sideFilterDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h4 class="h4 mb-4">{{ __('home.BlockUnblockRoom') }}</h4>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="blockunblock_form">
                        <div class="side-filterBody">
                            <div class="rangeslider">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="h6 mb-2">{{ __('home.rooms') }}</h6>
                                        <div class="form-floating mb-3 multiselectDropdownField">
                                            <!-- <button id="SelectClaim" data-bs-toggle="dropdown" class="form-select" aria-expanded="false"></button> -->
                                            <input id="selectRooms" name="select_rooms"  value="" data-bs-toggle="dropdown" class="form-select" placeholder="Select Rooms" autocomplete="off" />
                                            <ul class="dropdown-menu dropdown-menu-start">
                                                @foreach ($rooms as $room)
                                                <li class="radiobox-image">
                                                    <input type="checkbox" id="room_{{$room->slug}}" name="room[]" value="{{$room->slug}}" class="checkuncheckroom" data-rn="{{$room->room_name}}" />
                                                    <label for="room_{{$room->slug}}">{{$room->room_name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <!-- <label for="SelectClaim" class="label">{{ __('home.') }}<span class="required-star">*</span></label> -->
                                        </div>
                                        <div class="selectedTabsRw d-flex flex-wrap align-items-center" id="checked_rooms">
                                            
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="h6 mb-2">{{ __('home.DatePeriod') }}</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-floating datepickerField">
                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="rbunbstart_date" placeholder="{{ __('home.startDate') }}" name="start_date">
                                            <label for="rbunbstart_date">{{ __('home.startDate') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-floating datepickerField">
                                            <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="rbunbend_date" placeholder="{{ __('home.endDate') }}"  name="end_date">
                                            <label for="rbunbend_date">{{ __('home.endDate') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="h6 mb-2">{{ __('home.Function') }}</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="selectChips">
                                            <input type="radio" name="type" value="block">
                                            <div class="itemchips">{{ __('home.Block') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="selectChips">
                                            <input type="radio" name="type" value="unblock">
                                            <div class="itemchips">{{ __('home.UnBlock') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                        <div class="side-filterFooter d-flex align-items-center justify-content-between">
                            <button type="button" class="btn w-100 block_unblock">{{ __('home.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script src="{{ asset('/assets/js/fullcalender.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type='text/javascript'>
    document.addEventListener('DOMContentLoaded', function() {
       
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true, //can click to set event
            selectMirror: true, // so it's solid 
            unselectAuto: false, //if you click outside calendar, event doesn't disappear, but if you click inside calendar, event still disappears
            eventStartEditable: true,
            eventResizableFromStart: true,
            eventDurationEditable: true,
            /* select: function(selectionInfo) {
                calendar.addEvent({
                    title: 'dynamic event',
                    start: selectionInfo.start,
                    end: selectionInfo.end //need these and not endTime/startTime, otherwise they won't re-render
                });
                calendar.unselect();
            }, */  
            eventClick: function(eventClickInfo) {

                // eventClickInfo.event.remove();
               //  alert('clicked on event.');
            },
           // events: "{{ route('get-calendar-data') }}"
           events: function (fetchInfo, successCallback, failureCallback) {
                let start=fetchInfo;
                 console.log(start.startStr)
                   console.log(start.endStr)
                var year = start.start;
                year=year.getMonth();
              
                    $.ajax({
                        url: "{{ route('get-calendar-data') }}",
                        dataType: 'json',
                        data:{
                            startdate: start.startStr,
                            enddate: start.endStr,
                            _token:"{{ csrf_token() }}"
                        },
                        type: 'POST',
                        success: function(response) {
                            successCallback(response); 
                            $(document).find('.fc-event-title').each(function(){
                               if($(this).hasClass('already-slite')==false){
                                $(this).css('width','100%')
                                 let thisdata=$(this).text();
                                 let ar=thisdata.split('--');
                                 $(this).html("<label>"+ar[0]+"</label><label style='float:right'>"+ar[1]+"</label>");
                                 $(this).addClass('already-slite')
                               }
                            })
                        }
                    })
            },
            /* calendar.addEvent({
                    title: 'dynamic event',
                    start: selectionInfo.start,
                    end: selectionInfo.end //need these and not endTime/startTime, otherwise they won't re-render
                });*/
               
             

        });

        
        calendar.render();
        function getEvents() {
            console.log(calendar.getEvents());
        }

        $(document).ready(function(){
            /* $(document).on('click','.fc-prev-button span',function(){
                var date = calendar.getDate();
                var month_int = date.getMonth();
                console.log(month_int);
                // var monthText = $('#fc-dom-1').text(); 
                // alert('prev is clicked, do something '+monthText);
            });
            
            $(document).on('click','.fc-next-button span',function(){
                var date = calendar.getDate();
                var month_int = date.getMonth();
                var month_int = date.getFullYear();
                console.log(month_int);
                // var monthText = $('#fc-dom-1').text(); 
                // alert('nextis clicked, do something '+monthText);
            }); */ 
        });

        // $('#fc-dom-1').text('test'); 


    });
</script>
<script>
    $(document).ready(function(){
        
        var block_unblock_success_msg = "{{ $block_unblock_success_msg }}";
        if(block_unblock_success_msg !='')
        {
            $("#commonSuccessMsg").text(block_unblock_success_msg);
            $("#commonSuccessBox").css('display','block');
            setTimeout(function() {
                $("#commonSuccessBox").hide();
            }, 3000);
        }
        $(document).on('click','.block_unblock',function(){
            form_submit();
        });  
        
        function form_submit()
        { 
            var token=true; 
            if(token)
            {
                $(".block_unblock").prop("disabled",true); 
                loading();
                let formdata = $( "#blockunblock_form" ).serialize();
                $.post("{{ route('room-block-unblock') }}", formdata, function( data ) {
                    if(data.status==1){
                        // window.location.href = data.nextpageurl; 
                        /* $(".sideFilterDialog").modal('hide');
                        $("#commonSuccessMsg").text(data.message);
                        $("#commonSuccessBox").css('display','block'); */
                        location.reload();
                        // getEvents();
                        unloading();
                    } 
                    else
                    {
                        $(".block_unblock").prop("disabled",false); 
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
        // check uncheck room 
        $(document).on('click','.checkuncheckroom',function(){
            val = $(this).val(); 
            name = $(this).attr('data-rn'); 
            if($(this).prop("checked") == true)
            {
                $("#checked_rooms").prepend(' <p class="selectchip"  data-fi="'+val+'" id="room_chip_'+val+'">'+name+'<span class="closechps delete_checkedroom" data-fi="'+val+'">×</span></p>');
            }     // console.log(val);
            else    
               { $("#room_chip_"+val).remove(); $('#room_'+val).prop('checked', false); } 
               // console.log('else '+val);
        });
        // remove room 
        $(document).on('click','.delete_checkedroom',function(){
            val = $(this).attr('data-fi'); 
            console.log(val);
            console.log("#room_chip_"+val);
            $("#room_chip_"+val).remove();
            $('#room_'+val).prop('checked', false); 
        });
    });
</script>
@endsection
