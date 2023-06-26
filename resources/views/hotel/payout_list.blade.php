@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right earnings-payouts-sec">
            <div class="container-fluid">
                <div class="heading-sec mb-4">
                    <h5 class="h5 mb-2 d-flex justify-content-start align-items-center">{{ __('home.earningsAndPayouts') }} 
                    @if(isset($hotelInfo->total_payble_payout) && auth()->user()->access !='admin')    
                    <span class="reward-box">
                        @php /* <img src="{{asset('/assets/images/')}}/structure/stars-circle.svg" alt=".." class="icon24"> */ @endphp
                        <span>Total Payout Amount ₩ {{ $hotelInfo->total_payble_payout; }}</span>
                    </span>
                    @endif
                    </h5>
                    <form action="" method="post" id="payout_lsiting">
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                    @if(auth()->user()->access =='admin')
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">{{ __('home.HotelList') }}</span>
                                <div class="">
                                    <button id="child1" data-bs-toggle="dropdown" class="form-select text-capitalize overflow-ellip-140">{{ (isset($hname) && $hname !='')?$hname:'All'; }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image">
                                            <input type="radio" id="h" name="h" value="" class="filter_by_h" {{ (isset($h) && $h=='' )?'checked':'' }} />
                                            <label for="h">{{ __('home.All') }}</label>
                                        </li>
                                        @foreach ($hotels as $hotel)
                                        <li class="radiobox-image">
                                            <input type="radio" id="h_{{ $hotel->slug }}" name="h" value="{{ $hotel->slug }}" class="filter_by_h" {{ (isset($h) && $h==$hotel->slug )?'checked':'' }} />
                                            <label for="h_{{ $hotel->slug }}">{{ $hotel->hotel_name }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">{{ __('home.payoutStatus') }}</span>
                                <div class="">
                                    <button id="child11" data-bs-toggle="dropdown" class="form-select text-capitalize">{{ (isset($status) && $status!='')?$status:'All' }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image">
                                            <input type="radio" id="status_all" name="status" value="" class="plfilter_by_pstatus" {{ (isset($status) && $status=='')?'checked':'' }} />
                                            <label for="status_all">{{ __('home.All') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input type="radio" id="status_paid" name="status" value="paid" class="plfilter_by_pstatus" {{ (isset($status) && $status=='paid')?'checked':'' }} />
                                            <label for="status_paid" class="text-capitalize">{{ __('home.paid') }} </label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input type="radio" id="status_planned" name="status" value="planned" class="plfilter_by_pstatus" {{ (isset($status) && $status=='planned')?'checked':'' }}/>
                                            <label for="status_planned" class="text-capitalize">{{ __('home.Planned') }}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="filter-header-col">
                            <div class="datepickerField">
                                <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                <input type="text" class="form-control datepicker edsd keyBoardFalse rightClickDisabled" autocomplete="off" id="sd" placeholder="{{ __('home.startDate') }} " name="sd" value="{{ (isset($sd))?$sd:''; }}">
                            </div>
                        </div>
                        <div class="filter-header-col">
                            <div class="datepickerField">
                                <img src="{{asset('/assets/images/')}}/structure/calendar1.svg" alt="" class="calendarIcon" />
                                <input type="text" class="form-control datepicker edsd keyBoardFalse rightClickDisabled" autocomplete="off" id="ed" placeholder="{{ __('home.endDate') }} " name="ed" value="{{ (isset($ed))?$ed:''; }}">
                            </div>
                        </div>
                        
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                         <a  href="{{ route('my-payouts') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <button type="button" class="btn h-36" id="export_csv">{{ __('home.ExportCSV') }} </button>
                        </div>                       
                    </div>
                    </from>
                </div>
                <!-- <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="../images/structure/earning-payout-empty-img.png" alt="" class="empty-list-image">
                        <h6>Your earnings & payouts list is empty</h6>
                        <p class="p3">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                    </div>
                </div> -->
                <div class="tableboxpadding0">
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                  @if(auth()->user()->access == 'admin')
                                    <th>
                                        <p>
                                            Hotel Name 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='hotel_info.hotel_name' && $o=='desc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='hotel_info.hotel_name' && $o=='asc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    @endif
                                    <th>
                                        <p>
                                        {{ __('home.salesPeriod') }} 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='sales_period_start' && $o=='desc')?'hidesorticon':''; }}" data-c="sales_period_start" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='sales_period_start' && $o=='asc')?'hidesorticon':''; }}" data-c="sales_period_start" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.paymentDate') }} 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='settlement_date' && $o=='desc')?'hidesorticon':''; }}" data-c="settlement_date" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='settlement_date' && $o=='asc')?'hidesorticon':''; }}" data-c="settlement_date" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.salesAmount') }} 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='sales_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="sales_amount" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='sales_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="sales_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.PayoutAmount') }} 
                                            <span class="sort-arrow-table">
                                            <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='payble_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="payble_amount" data-o="asc"></i>
                                            <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='payble_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="payble_amount" data-o="desc"></i>
                                        </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.payoutStatus') }} 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='pay_status' && $o=='desc')?'hidesorticon':''; }}" data-c="pay_status" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='pay_status' && $o=='asc')?'hidesorticon':''; }}" data-c="pay_status" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    @if(auth()->user()->access == 'admin')
                                    <th>
                                        <p>
                                            Action
                                        </p>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $row)
                                @php
                                $sales_period_start = new DateTime($row->sales_period_start);
                                $sales_period_end = new DateTime($row->sales_period_end);
                                $settlement_date = new DateTime($row->settlement_date);
                                @endphp
                                <tr>    
                                    @if(auth()->user()->access == 'admin')                              
                                    <td><a href="{{ route('payout-details',$row->slug) }}">{{ $row->hotel_name  }}</a></td>
                                    @endif
                                    <td><a href="{{ route('payout-details',$row->slug) }}">{{ date_format($sales_period_start,"Y-m-d"); }} - {{ date_format($sales_period_end,"Y-m-d"); }}</a></td>
                                    <td><a href="{{ route('payout-details',$row->slug) }}">{{ date_format($settlement_date,"Y-m-d"); }}</a></td>
                                    <td><a href="{{ route('payout-details',$row->slug) }}">₩ {{ $row->sales_amount }}</a></td>
                                    <td><a href="{{ route('payout-details',$row->slug) }}">₩ {{ $row->payble_amount }}</a></td>
                                    <td><span class="chips chips-{{ $row->pay_status  }} text-capitalize">{{ $row->pay_status  }}</span></td>
                                    @if(auth()->user()->access == 'admin')
                                    @if($row->pay_status =='planned')
                                    <td class="actionDropdown ">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        @if(auth()->user()->access == 'admin')  
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li> 
                                                <a class="dropdown-item markPaid" href="" data-i="{{ $row->id }}" data-bs-toggle="modal" data-bs-target=".markpaidDialog">Mark Paid</a>
                                            </li>
                                        </ul>
                                        @endif
                                    </td>
                                    @else
                                    <td> &nbsp;&nbsp;&nbsp;&nbsp;- </td>
                                    @endif
                                    @endif
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
                <ul class="pagination justify-content-center">
                    {{$list->appends(Request::only(['search','list']))->links('pagination::bootstrap-4')}}
                </ul>
            </div>
        </div>
        <div class="modal fade markpaidDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3 mt-2">Mark Paid</h3>
                        <p class="p2 mb-4">Are you sure you want to mark as piad this payout?</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button type="button" class="btn bg-gray flex-fill" id="markPaidYes" data-i="0">Yes</button>
                        <button type="button" class="btn flex-fill" data-bs-dismiss="modal">No</button>
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
        $(document).on('click','.sortdata',function(){
            // console.log('sort');
            var o = $(this).attr('data-o');
            // var i = $(this).attr('data-i');
            var c = $(this).attr('data-c');
            //  console.log(o+" "+c);
            var url = "{{ route('my-payouts') }}"; 
            url = url+'?o='+o+'&c='+c;//+'&i='+i;    
            window.location.href = url;
        });
        $(document).on('click','.plfilter_by_pstatus',function(){
            $(this).attr('checked', true);
            $( "#payout_lsiting" ).submit();
        });
        $(document).on('change','.edsd',function(){
            let sd = $("#sd").val();
            let ed = $("#ed").val();
            if(sd !='' && ed !='')
            $( "#payout_lsiting" ).submit();
        });

        $(document).on('click','.filter_by_h',function(){
            $(this).attr('checked', true);
            $( "#payout_lsiting" ).submit();
        });

        $(document).on('click','#export_csv',function(){
            let rows = <?php echo json_encode($exportRows); ?>; 
            let filename = <?php echo json_encode($filename); ?>; 
            // console.log(rows); 
            // alert(rows[1]);
        //  rows2 = JSON.stringify(rows); // JSON.parse(rows);
        //      console.log(rows2);
            //[ ['Sales Period ', 'Payment Date','Sales Amount','Payout Amount','Payout Status'], ['1', 'English'],  ['17', 'नेपाली'],  ['18', 'हिंदी'], ['23', '日本語'] ];
           exportToCsv(filename, rows);
        }); 
        function exportToCsv(filename, rows) { var processRow = function (row) { var finalVal = ''; for (var j = 0; j < row.length; j++) { var innerValue = row[j] === null ? '' : row[j].toString(); if (row[j] instanceof Date) { innerValue = row[j].toLocaleString(); }; var result = innerValue.replace(/"/g, '""'); if (result.search(/("|,|\n)/g) >= 0) result = '"' + result + '"'; if (j > 0) finalVal += ','; finalVal += result; } return finalVal + '\n'; }; var csvFile = ''; for (var i = 0; i < rows.length; i++) { csvFile += processRow(rows[i]); } var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' }); __export(blob, filename + ".csv"); }
        function __export(blob, filename) {
            console.log(filename);
            if (navigator.msSaveBlob) { navigator.msSaveBlob(blob, filename); } else { var link = document.createElement("a"); if (link.download !== undefined) { var url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); } }
            }
            
        $(document).on('click','.markPaid',function(){
            var i = $(this).attr('data-i');
            $("#markPaidYes").attr('data-i',i);                
        });            
        $(document).on('click','#markPaidYes',function(){
            var i = $(this).attr('data-i');
            var url = "{{ route('payout-mark-paid',['id'=>':i'])}}";  
            url = url.replace(':i', i);
            window.location.href = url;
        });    
    });
</script>
<style>
    .daterangepicker.dropdown-menu.ltr.show-calendar.opensright {
        left: auto !important;
        right: 0 !important;
    }
</style>
@endsection
