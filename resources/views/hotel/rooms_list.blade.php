@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right rooms-managment-sec">
            <div class="container-fluid">
                @if(count($rooms) > 0)
                <div class="heading-sec mb-4 d-flex align-items-center">
                    <h5 class="h5  mb-0">{{ __('home.RoomList') }}</h5>
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <a href="{{ route('room_basic_info','new')}}" class="btn h-36">{{ __('home.AddRoom') }}</a>
                        </div>
                    </div>
                </div>
                @endif
                @if(count($rooms) == 0)
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/room-empty-image.png" alt="" class="empty-list-image">
                        <h6>{{ __('home.NoRoomRegistered') }}</h6>
                        <a class="btn" href="{{ route('room_basic_info','new')}}">{{ __('home.AddRoom') }}</a>
                    </div>
                </div>
                @endif
                @if(count($rooms) >0 )
                <div class="tableboxpadding0">
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            {{ __('home.Room') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='room_name' && $o=='desc')?'hidesorticon':''; }}" data-c="room_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='room_name' && $o=='asc')?'hidesorticon':''; }}" data-c="room_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.RoomSize') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='room_size' && $o=='desc')?'hidesorticon':''; }}" data-c="room_size" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='room_size' && $o=='asc')?'hidesorticon':''; }}" data-c="room_size" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.BathRoom') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='no_of_bathrooms' && $o=='desc')?'hidesorticon':''; }}" data-c="no_of_bathrooms" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='no_of_bathrooms' && $o=='asc')?'hidesorticon':''; }}" data-c="no_of_bathrooms" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.StandardOccupancy') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='standard_occupancy' && $o=='desc')?'hidesorticon':''; }}" data-c="standard_occupancy" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='standard_occupancy' && $o=='asc')?'hidesorticon':''; }}" data-c="standard_occupancy" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.MaxOccupancy') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='maximum_occupancy' && $o=='desc')?'hidesorticon':''; }}" data-c="maximum_occupancy" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='maximum_occupancy' && $o=='asc')?'hidesorticon':''; }}" data-c="maximum_occupancy" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.Weekday') }} {{ __('home.Price') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='standard_price_weekday' && $o=='desc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='standard_price_weekday' && $o=='asc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.Weekend') }} {{ __('home.Price') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='standard_price_weekday' && $o=='desc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='standard_price_weekday' && $o=='asc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.PeakSeason') }} {{ __('home.Price') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='standard_price_weekday' && $o=='desc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='standard_price_weekday' && $o=='asc')?'hidesorticon':''; }}" data-c="standard_price_weekday" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.ExtraGuestFee') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='extra_guest_fee' && $o=='desc')?'hidesorticon':''; }}" data-c="extra_guest_fee" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='extra_guest_fee' && $o=='asc')?'hidesorticon':''; }}" data-c="extra_guest_fee" data-o="desc"></i>
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                <tr>
                                    <td>{{ (strlen($room->room_name)>35)?substr($room->room_name,0,35).'..':$room->room_name; }}</td>
                                    <td>{{$room->room_size}} m<sup>2<sup></td>
                                    <td>{{$room->no_of_bathrooms}}</td>
                                    <td>{{$room->standard_occupancy}}</td>
                                    <td>{{$room->maximum_occupancy}}</td>
                                    <td>₩ {{number_format($room->standard_price_weekday)}}</td>
                                    <td>₩ {{number_format($room->standard_price_weekend)}}</td>
                                    <td>₩ {{number_format($room->standard_price_peakseason)}}</td>
                                    <td>₩ {{number_format($room->extra_guest_fee)}}</td>
                                    <td class="actionDropdown">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="..." class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('room_basic_info',$room->slug) }}"><img src="{{asset('/assets/images/')}}/structure/edit.svg" alt="" class="editIcon">{{ __('home.Edit') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delRoom" data-i="{{ $room->slug }}" href="" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon">{{ __('home.Delete') }}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$rooms->appends(Request::only(['search','room']))->links('pagination::bootstrap-4')}}
                @endif
            </div>
        </div>
<!--Delete Modal -->
<div class="modal fade warningDialog" tabindex="-1" aria-labelledby="warningDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads">
                    <div class="text-center">
                        <img src="{{asset('/assets/images/')}}structure/warning-red.svg" alt="" class="warningIcon">
                        <h4 class="h4 mt-2">Oops!</h4>
                        <p class="p2 mb-4">{{ __('home.Youalreadyhaveabookingsoannotdeleteit') }}</p>
                    </div>
                    <a href="" class="btn w-100" data-bs-dismiss="modal">{{ __('home.OK') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- common models -->
@include('common_modal')
<!--Delete Modal -->
<div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads">
                    <h3 class="h3 mt-2">{{ __('home.DeleteRoom') }}</h3>
                    <p class="p2 mb-4">{{ __('home.ConfirmRoomDelete') }}</p>
                </div>
                <div class="d-flex btns-rw">
                    <button class="btn bg-gray flex-fill" id="roomDelYes" data-i="0">{{ __('home.Yes') }}</button>
                    <button class="btn flex-fill" data-bs-dismiss="modal">{{ __('home.No') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        $(document).on('click','.sortdata',function(){
            // console.log('sort');
            var o = $(this).attr('data-o');
            // var i = $(this).attr('data-i');
            var c = $(this).attr('data-c');
            //  console.log(o+" "+c);
            var url = "{{ route('rooms') }}"; 
            url = url+'?o='+o+'&c='+c;//+'&i='+i;    
            window.location.href = url;
        });
        // delete account 
        $(document).on('click','.delRoom',function(){
                var i = $(this).attr('data-i');
                $("#roomDelYes").attr('data-i',i);                
        });            
        $(document).on('click','#roomDelYes',function(){
            var i = $(this).attr('data-i');
            var url = "{{ route('room_status',['slug'=>':i','status'=>'deleted'])}}";  
            url = url.replace(':i', i);
            // alert(url);
            window.location.href = url;
        });
    });
</script>
@endsection
