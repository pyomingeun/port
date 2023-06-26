@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        @php
            $sales_period_start = new DateTime($payout->sales_period_start);
            $sales_period_end = new DateTime($payout->sales_period_end);
            $settlement_date = new DateTime($payout->settlement_date);
        @endphp
        <div class="content-box-right earnings-payouts-deatil-sec">
            <div class="container-fluid">
            <div class="mb-3" style="text-align: right;">
                            <button type="button" class="btn h-36" id="export_csv">{{ __('home.ExportCSV') }} </button>
                        </div>      
                <div class="whitebox-w mb-5 bookings-htl-dtl-box-w">
                    <div class="white-card-header d-flex align-items-center flex-wrap">
                        <div>
                            <p class="p1 mb-0 d-flex align-items-center dtl-wt-back-btn">
                                <a href="{{ route('my-payouts'); }}" class="back-a"><img src="{{asset('/assets/images/')}}//structure/back-arrow.svg" alt="Back" class="backbtn cursor-p"></a> {{ __('home.payoutDetails') }} </p>
                        </div>
                        <div class="ml-auto">
                            <span class="chips chips-{{ $payout->pay_status }} text-capitalize">{{ $payout->pay_status }}</span>
                        </div>
                    </div>
                    <div class="white-card-body">
                        <div class="payoutDetailRow d-flex flex-wrap">
                            <div class="payoutDetailCol">
                                <p class="p3 mb-2">{{ __('home.salesPeriod') }}</p>
                                <h6 class="h6 mb-0">{{ date_format($sales_period_start,"Y-m-d"); }} - {{ date_format($sales_period_end,"Y-m-d"); }}</h6>
                            </div>
                            <div class="payoutDetailCol">
                                <p class="p3 mb-2">{{ __('home.payoutDate') }}</p>
                                <h6 class="h6 mb-0">{{ date_format($settlement_date,"Y-m-d"); }}</h6>
                            </div>
                            <div class="payoutDetailCol">
                                <p class="p3 mb-2">{{ __('home.totalBookings') }}</p>
                                <h6 class="h6 mb-0">{{ $payout->no_of_bookings }}</h6>
                            </div>
                            <div class="payoutDetailCol">
                                <p class="p3 mb-2">{{ __('home.salesAmount') }}</p>
                                <h6 class="h6 mb-0">₩ {{ $payout->sales_amount }}</h6>
                            </div>
                            <div class="payoutDetailCol">
                                <p class="p3 mb-2">{{ __('home.payoutAmount') }}</p>
                                <h6 class="h6 mb-0 text-green">₩ {{ $payout->payble_amount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="h5 hd5">{{ __('home.payoutHistory') }}</h5>
                
                <div class="tableboxpadding0">
                    <!-- <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                            <img src="../images/structure/wallet-green.svg" alt="" class="empty-list-image">
                            <h6>Currently Running</h6>
                            <p class="p3">Currently this is running payout cycle. Payout history will shown after completion of cycle.</p>
                        </div>
                    </div> -->
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            {{ __('home.bookingNo') }}.
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.slug' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.slug" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.slug' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.slug" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.room') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rooms.room_name' && $o=='desc')?'hidesorticon':''; }}" data-c="rooms.room_name" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='rooms.room_name' && $o=='asc')?'hidesorticon':''; }}" data-c="rooms.room_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.guestName') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.customer_full_name' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.customer_full_name" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.customer_full_name' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.customer_full_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.salesDate') }}
                                            <span class="sort-arrow-table">
                                            <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.check_out_date' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.check_out_date" data-o="asc"></i>
                                            <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.check_out_date' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.check_out_date" data-o="desc"></i>
                                        </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                             {{ __('home.cancelDate') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.cancelled_at' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.cancelled_at" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.cancelled_at' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.cancelled_at" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.checkIn') }} - {{ __('home.checkOut') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.check_in_date' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.check_in_date" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.check_in_date' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.check_in_date" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.salesAmount') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='payout_history.sales_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="payout_history.sales_amount" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='payout_history.sales_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="payout_history.sales_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                             {{ __('home.coupon') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.coupon_discount_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.coupon_discount_amount" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.coupon_discount_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.coupon_discount_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.discount') }}
                                            @php
                                            /*
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='room_name' && $o=='desc')?'hidesorticon':''; }}" data-c="room_name" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down {{ ($c=='room_name' && $o=='asc')?'hidesorticon':''; }}" data-c="room_name" data-o="desc"></i>
                                            </span>
                                            */
                                            @endphp
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.GatewayType') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.payment_method' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.payment_method" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.payment_method' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.payment_method" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.commissionRate') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='commission_rate' && $o=='desc')?'hidesorticon':''; }}" data-c="commission_rate" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='commission_rate' && $o=='asc')?'hidesorticon':''; }}" data-c="commission_rate" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.commission') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='payout_history.commission' && $o=='desc')?'hidesorticon':''; }}" data-c="payout_history.commission" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='payout_history.commission' && $o=='asc')?'hidesorticon':''; }}" data-c="payout_history.commission" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                        {{ __('home.payoutAmount') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='payout_history.payble_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="payout_history.payble_amount" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='payout_history.payble_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="payout_history.payble_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.BookingStatus') }}
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='bookings.booking_status' && $o=='desc')?'hidesorticon':''; }}" data-c="bookings.booking_status" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='bookings.booking_status' && $o=='asc')?'hidesorticon':''; }}" data-c="bookings.booking_status" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $row)
                                @php
                                $check_out_date = new DateTime($row->check_out_date);
                                $check_in_date = new DateTime($row->check_in_date);
                                if($row->cancelled_at !='' && $row->cancelled_at !=NULL)
                                    $cancelled_at = new DateTime($row->cancelled_at);
                                else
                                   $cancelled_at ='';
                                @endphp
                                <tr>
                                    <td>{{ $row->slug }}</td>
                                    <td>{{ $row->room_name }}</td>
                                    <td>
                                        <div class="overflow-ellips-custom">{{ $row->customer_full_name }}</div>
                                    </td>
                                    <td>{{ date_format($check_out_date,"Y-m-d"); }}</td>
                                    @if($cancelled_at !='')
                                    <td>{{ date_format($cancelled_at,"Y-m-d"); }}</td>
                                    @else
                                    <td>{{ $cancelled_at; }}</td>
                                    @endif
                                    <td>{{ date_format($check_in_date,"Y-m-d"); }} - {{ date_format($check_out_date,"Y-m-d"); }}</td>
                                    <td>₩ {{ $row->sales_amount }}</td>
                                    <td>₩ {{ $row->coupon_discount_amount }}</td>
                                    <td>₩ {{ $row->long_stay_discount_amount+ $row->additional_discount }}</td>
                                    <td ><span style="text-transform: capitalize !important; ">{{ str_replace("_"," ", $row->payment_method); }}</span></td>
                                    <td>{{ $row->commission_rate }}%</td>
                                    <td>₩ {{ $row->commission }}</td>
                                    <td>₩ {{ $row->payble_amount}}</td>
                                    <td><span class="chips chips-{{ $row->booking_status }} text-capitalize">{{ $row->booking_status}}</span></td>
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
            var url = "{{ route('payout-details',$payout->slug) }}"; 
            url = url+'?o='+o+'&c='+c;//+'&i='+i;    
            window.location.href = url;
        });

        $(document).on('click','#export_csv',function(){
            let rows = <?php echo json_encode($exportRows); ?>; 
            let filename = <?php echo json_encode($filename); ?>; 
           exportToCsv(filename, rows);
        }); 
        function exportToCsv(filename, rows) { var processRow = function (row) { var finalVal = ''; for (var j = 0; j < row.length; j++) { var innerValue = row[j] === null ? '' : row[j].toString(); if (row[j] instanceof Date) { innerValue = row[j].toLocaleString(); }; var result = innerValue.replace(/"/g, '""'); if (result.search(/("|,|\n)/g) >= 0) result = '"' + result + '"'; if (j > 0) finalVal += ','; finalVal += result; } return finalVal + '\n'; }; var csvFile = ''; for (var i = 0; i < rows.length; i++) { csvFile += processRow(rows[i]); } var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' }); __export(blob, filename + ".csv"); }
        function __export(blob, filename) {
            console.log(filename);
            if (navigator.msSaveBlob) { navigator.msSaveBlob(blob, filename); } else { var link = document.createElement("a"); if (link.download !== undefined) { var url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); } }
        }
    
    });
</script>
<style>
            .daterangepicker.dropdown-menu.ltr.show-calendar.opensright {
                left: auto !important;
                right: 0 !important;
            }
        </style>
@endsection