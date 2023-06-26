@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->

    <div class="main-wrapper-gray">
        @include('admin.leftbar')
        <div class="content-box-right earnings-payouts-sec">
            <div class="container-fluid">
                <h5 class="h5  mb-3">Hotel Staff {{ (isset($hotel->hotel_name))?'('.$hotel->hotel_name.')':'' }}</h5>
                <div class="heading-sec mb-4 d-flex align-items-center">
                    
                    <form action="" method="get" id="sm_lsiting">
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        <div class="filter-header-col searchFilBox ms-0">
                            <img src="{{asset('/assets/images/')}}/structure/search-gray.svg" alt="" class="searchIcon" />
                            <input type="text" class="form-control onenter_sumbit_hml" placeholder="Search"  name="q" value="{{ (isset($q))?$q:''; }}"/>
                        </div>
                        <!-- <div class="filter-header-col d-flex align-items-center doubleDatpickerBox">
                            <img src="{{asset('/assets/images/')}}/structure/calendar.svg" alt="" class="calendarIcon" />
                            <input type="text" class="form-control doubledatepicker onenter_sumbit_hml" placeholder="" value="{{ (isset($dates))?$dates:''; }}"  name="dates"  />
                        </div> -->
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">Status:</span>
                                <div class="">
                                    <button type="button" id="child1" data-bs-toggle="dropdown" class="form-select">{{ (isset($status) && $status!='')?ucwords($status):'All' }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image filter_by_status">
                                            <input class="smfilter_by_status"  type="radio" id="payout1" name="status" value=""  {{ (isset($status) && $status=='')?'checked':'' }} />
                                            <label for="payout1">All</label>
                                        </li>
                                        <li class="radiobox-image filter_by_status">
                                            <input class="smfilter_by_status" type="radio" id="payout2" name="status" value="active" {{ (isset($status) && $status=='active')?'checked':'' }} />
                                            <label for="payout2">Active</label>
                                        </li>
                                        <li class="radiobox-image filter_by_status">
                                            <input class="smfilter_by_status" type="radio" id="payout3" name="status" value="inactive" {{ (isset($status) && $status=='inactive')?'checked':'' }} />
                                            <label for="payout3">Inactive</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="filter-header-col filter-dd-wt-sd-lable">
                            <button type="submit" name="apply" class="btn h-36">Apply</button>
                        </div> -->
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                         <a  href="{{ route('staff_management','all') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <input type="hidden" name="c" value="{{ (isset($c))?$c:''; }}">
                        <input type="hidden" name="o" value="{{ (isset($o))?$o:''; }}">
                        
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <a class="btn h-36" href="{{route('hotel_staff_input',0)}}">Add New Staff Member</a>
                        </div>
                    </div>
                    </form>
                </div>

                <!-- <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/earning-payout-empty-img.png" alt="" class="empty-list-image">
                        <h6>Your earnings & payouts list is empty</h6>
                        <p class="p3">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                    </div>
                </div> -->
                <div class="tableboxpadding0">
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            Hotel Name
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='hotel_info.full_name' && $o=='desc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='hotel_info.full_name' && $o=='asc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Employee Name
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='user.full_name' && $o=='desc')?'hidesorticon':''; }}" data-c="user.full_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='user.full_name' && $o=='asc')?'hidesorticon':''; }}" data-c="user.full_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Email 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='user.email' && $o=='desc')?'hidesorticon':''; }}" data-c="user.email" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='user.email' && $o=='asc')?'hidesorticon':''; }}" data-c="user.email" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>                                                                        
                                    <th>
                                        <p>
                                           Status
                                           <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='user.status' && $o=='desc')?'hidesorticon':''; }}" data-c="user.status" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='user.status' && $o=='asc')?'hidesorticon':''; }}" data-c="user.status" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Action
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel_staff as $row)
                                <tr>
                                    <!-- <td><a href="payout-detail-planned-hotel-manager.html">2022/08/29 - 2022/09/04</a></td> -->
                                    <td>{{ (strlen($row->hotel_name)>35)?substr($row->hotel_name,0,35).'..':$row->hotel_name; }}</td>                                  
                                    <td>{{ (strlen($row->full_name)>35)?substr($row->full_name,0,35).'..':$row->full_name; }}</td>
                                    <td>{{ (strlen($row->email)>35)?substr($row->email,0,35).'..':$row->email; }}</td>

                                    <!-- <td><span class="chips chips-orange">Planned</span></td> -->
                                    <td class="text-capitalize"><a href="{{ route('staff_status',['id'=>$row->id,'status'=>$row->status])}}"><span class="cursor-pointer chips chips-{{$row->status}}">{{$row->status}}</span></a></td>
                                    <td class="actionDropdown ">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('hotel_staff_input',$row->id)}}"><img src="{{asset('/assets/images/')}}/structure/edit.svg" alt="" class="editIcon"> Edit</a>
                                            </li>
                                            <li> 
                                                <a class="dropdown-item delUser" href="" data-i="{{ $row->id }}" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon"> Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="JavaScript:Void(0);" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="JavaScript:Void(0);">1</a></li>
                    <li class="page-item"><a class="page-link" href="JavaScript:Void(0);">2</a></li>
                    <li class="page-item"><a class="page-link" href="JavaScript:Void(0);">3</a></li>
                    <li class="page-item"><a class="page-link" href="JavaScript:Void(0);">4</a></li>
                    <li class="page-item"><a class="page-link" href="JavaScript:Void(0);">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="JavaScript:Void(0);">Next</a>
                    </li>
                </ul> -->

                {{$hotel_staff->appends(Request::only(['search']))->links('pagination::bootstrap-4')}}
            </div>
        </div>
       


        
<!-- common models -->
@include('common_models')
<!--Delete Modal -->
<div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3 mt-2">Delete Account</h3>
                        <p class="p2 mb-4">Are you sure you want to delete this account?</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill" id="userDelYes" data-i="0">Yes</button>
                        <button class="btn flex-fill" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<style>
    .daterangepicker.dropdown-menu.ltr.show-calendar.opensright {
        left: auto !important;
        right: 0 !important;
    }
</style>

@include('frontend.layout.footer_script')
@endsection

    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function(){

            $(document).on('click','.smfilter_by_status',function(){
                $(this).attr('checked', true);
                $( "#sm_lsiting" ).submit();
            });

            $(function() {
                $('.doubledatepicker').daterangepicker();
            });

            $(document).on('click','.sortdata',function(){
                // console.log('sort');
                var o = $(this).attr('data-o');
                // var i = $(this).attr('data-i');
                var c = $(this).attr('data-c');
                //  console.log(o+" "+c);
                var url = "{{ route('staff_management',$id) }}"; 
                url = url+'?o='+o+'&c='+c;//+'&i='+i;    
                window.location.href = url;
                
            });

            // delete account 
            $(document).on('click','.delUser',function(){
                var i = $(this).attr('data-i');
                $("#userDelYes").attr('data-i',i);                
            });            
            $(document).on('click','#userDelYes',function(){
                var i = $(this).attr('data-i');
                var url = "{{ route('staff_status',['id'=>':i','status'=>'deleted'])}}";  
                url = url.replace(':i', i);
                window.location.href = url;
            });
        });    
    </script>   
    @endsection