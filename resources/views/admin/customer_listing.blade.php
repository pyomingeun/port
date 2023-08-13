@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->

    <div class="main-wrapper-gray">
        @include('admin.leftbar')
        <div class="content-box-right earnings-payouts-sec">
            <div class="container-fluid">
                     <h5 class="h5  mb-3">Customer Managment</h5>
                    <div class="heading-sec mb-4 d-flex align-items-center">
                   
                    <form action="" method="get" id="cm_lsiting">
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
                                        <li class="radiobox-image">
                                            <input  class="filter_by_status" type="radio" id="payout1" name="status" value=""  {{ (isset($status) && $status=='')?'checked':'' }} />
                                            <label for="payout1">All</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="filter_by_status" type="radio" id="payout2" name="status" value="active" {{ (isset($status) && $status=='active')?'checked':'' }} />
                                            <label for="payout2">Active</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="filter_by_status" type="radio" id="payout3" name="status" value="inactive" {{ (isset($status) && $status=='inactive')?'checked':'' }} />
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
                         <a  href="{{ route('customer_management') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <input type="hidden" name="c" value="{{ (isset($c))?$c:''; }}">
                        <input type="hidden" name="o" value="{{ (isset($o))?$o:''; }}">
                        
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
                                            Email 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='email' && $o=='desc')?'hidesorticon':''; }}" data-c="email" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='email' && $o=='asc')?'hidesorticon':''; }}" data-c="email" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Customer Name
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='full_name' && $o=='desc')?'hidesorticon':''; }}" data-c="full_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='full_name' && $o=='asc')?'hidesorticon':''; }}" data-c="full_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Phone
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='phone' && $o=='desc')?'hidesorticon':''; }}" data-c="phone" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata email_desc {{ ($c=='phone' && $o=='asc')?'hidesorticon':''; }}" data-c="phone" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Reward</br>Points
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='total_rewards_points' && $o=='desc')?'hidesorticon':''; }}" data-c="total_rewards_points" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata email_desc {{ ($c=='total_rewards_points' && $o=='asc')?'hidesorticon':''; }}" data-c="total_rewards_points" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                           Status
                                           <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='status' && $o=='desc')?'hidesorticon':''; }}" data-c="status" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='status' && $o=='asc')?'hidesorticon':''; }}" data-c="status" data-o="desc"></i>
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
                                @foreach ($users as $row)
                                <tr>
                                    <!-- <td><a href="payout-detail-planned-hotel-manager.html">2022/08/29 - 2022/09/04</a></td> -->
                                  
                                    <td>{{ (strlen($row->email)>35)?substr($row->email,0,35).'..':$row->email; }}</td>
                                    <td>{{ (strlen($row->full_name)>35)?substr($row->full_name,0,35).'..':$row->full_name; }}</td>
                                    <td>{{$row->phone}}</td>
                                    <td>{{$row->total_rewards_points}}</td>
                                    <!-- <td><span class="chips chips-orange">Planned</span></td> -->
                                    <td class="text-capitalize"><a href="{{ route('customer_status',['id'=>$row->id,'status'=>$row->status])}}"><span class="cursor-pointer chips chips-{{$row->status}}">{{$row->status}}</span></td>
                                    <td class="actionDropdown">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('customer_input',$row->id)}}"><img src="{{asset('/assets/images/')}}/structure/edit.svg" alt="" class="editIcon">Profile Edit</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('reward-details',$row->id)}}"><img src="{{asset('/assets/images/')}}/structure/eye-icon.svg" alt="" class="editIcon">View/Edit Rewards</a>
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

                {{$users->appends(Request::only(['search']))->links('pagination::bootstrap-4')}}
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

            $(function() {
                $('.doubledatepicker').daterangepicker();
            });
            /*
            google.charts.load('current', {
            'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Sales', 'Expenses', 'Profit'],
                    ['2014', 1000, 400, 200],
                    ['2015', 1170, 460, 250],
                    ['2016', 660, 1120, 300],
                    ['2017', 1030, 540, 350]
                ]);

                var options = {
                    chart: {
                        title: 'Company Performance',
                        subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            } */
            /// sorting
            $(document).on('click','.sortdata',function(){
                // console.log('sort');
                var o = $(this).attr('data-o');
                // var i = $(this).attr('data-i');
                var c = $(this).attr('data-c');
                //  console.log(o+" "+c);
                var url = "{{ route('customer_management') }}"; 
                url = url+'?o='+o+'&c='+c;//+'&i='+i;    
                window.location.href = url;
                
            });

            $(document).on('click','.filter_by_status',function(){
                $(this).attr('checked', true);
                // let formdata = $( "#cm_lsiting" ).serialize();
                // formdata.set('status', 'inactive');
                $( "#cm_lsiting" ).submit();
            });

            // delete account 
            $(document).on('click','.delUser',function(){
                var i = $(this).attr('data-i');
                $("#userDelYes").attr('data-i',i);                
            });            
            $(document).on('click','#userDelYes',function(){
                var i = $(this).attr('data-i');
                var url = "{{ route('customer_status',['id'=>':i','status'=>'deleted'])}}";  
                url = url.replace(':i', i);
                window.location.href = url;
            });
            
            
        });    
    </script>   
    @endsection