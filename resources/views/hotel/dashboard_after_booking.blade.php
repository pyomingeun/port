@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'admin')
            @include('admin.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right dashboard-sec">
            <div class="container-fluid">
                <div class="dshboard-booking-blocks-rw d-flex flex-wrap">
                    <a href="{{ route('bookings'); }}" class="dshboard-booking-blocks-cl">
                        <img src="{{asset('/assets/images/')}}/structure/beg-circle-orange.svg" alt="" class="bookingIcon" />
                        <p class="p3">{{ __('home.OnHoldBooking') }}</p>
                        <h5 class="h5 mb-0">{{ $noOfOnHoldBookings; }}</h5>
                    </a>
                    <a href="{{ route('bookings'); }}" class="dshboard-booking-blocks-cl">
                        <img src="{{asset('/assets/images/')}}/structure/beg-circle-green.svg" alt="" class="bookingIcon" />
                        <p class="p3">{{ __('home.ConfirmedBooking') }}</p>
                        <h5 class="h5 mb-0">{{ $noOfConfirmedBookings; }}</h5>
                    </a>
                    <a href="{{ route('bookings'); }}" class="dshboard-booking-blocks-cl">
                        <img src="{{asset('/assets/images/')}}/structure/beg-circle-red.svg" alt="" class="bookingIcon" />
                        <p class="p3">{{ __('home.CanceledBooking') }}</p>
                        <h5 class="h5 mb-0">{{ $noOfCancelledBookings; }}</h5>
                    </a>
                    <div class="ds-total-revenue-box">
                        <div class="d-flex">
                            <img src="{{asset('/assets/images/')}}/structure/wallet-account-balance_.svg" alt="" class="bookingIcon" />
                        </div>
                        <p class="p3">{{ __('home.MonthlyRevenue') }}</p>
                        <h5 class="h5 mb-0">₩ {{ $total_revenue }}</h5>
                    </div>
                </div>

                <div class="whitebox-w">
                    <h5 class="h5 mb-4">{{ __('home.TodayCheckIn') }}</h5>
                    <div class="table-responsive table-view">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            {{ __('home.Guest') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.BookingReferenceNumber') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.Mobile') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.RoomName') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.GuestNote') }}
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkInBookings as $row)
                                <tr>
                                    <td>{{ $row->customer_full_name }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td>{{ $row->customer_phone }}</td>
                                    <td>{{ $row->room_name }}</td>
                                    <td>{{ $row->customer_notes }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="whitebox-w">
                    <h5 class="h5 mb-4">{{ __('home.TodayCheckOut') }}</h5>
                    <div class="table-responsive table-view">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            {{ __('home.Guest') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.BookingReferenceNumber') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.Mobile') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.RoomName') }}
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            {{ __('home.GuestNote') }}
                                        </p>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($checkOutBookings as $row)
                                <tr>
                                    <td>{{ $row->customer_full_name }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td>{{ $row->customer_phone }}</td>
                                    <td>{{ $row->room_name }}</td>
                                    <td>{{ $row->customer_notes }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="heading-sec mb-4 d-flex align-items-center">
                    <h5 class="h5 mb-0" style="margin-left: 20px;"> {{ __('home.RoomUitlizationRate') }}</h5>
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">{{ __('home.Month') }}:</span>
                                <div class="monthDropdown">
                                    <button id="child1" data-bs-toggle="dropdown" class="form-select">{{ $monthString }}</button>
                                    <ul class="dropdown-menu dropdown-menu-start">
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m1" name="month" value="1" {{ ($currentMonth ==1 )?'checked':''; }} />
                                            <label for="m1"> {{ __('home.Jan') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m2" name="month" value="2" {{ ($currentMonth ==2 )?'checked':''; }} />
                                            <label for="m2">{{ __('home.Feb') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m3" name="month" value="3" {{ ($currentMonth ==3 )?'checked':''; }} />
                                            <label for="m3">{{ __('home.Mar') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m4" name="month" value="4" {{ ($currentMonth ==4 )?'checked':''; }} />
                                            <label for="m4">{{ __('home.Apr') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m5" name="month" value="5" {{ ($currentMonth ==5 )?'checked':''; }} />
                                            <label for="m5">{{ __('home.May') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m6" name="month" value="6" {{ ($currentMonth ==6 )?'checked':''; }} />
                                            <label for="m6">{{ __('home.Jun') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m7" name="month" value="7" {{ ($currentMonth ==7 )?'checked':''; }} />
                                            <label for="m7">{{ __('home.Jul') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m8" name="month" value="8" {{ ($currentMonth ==8 )?'checked':''; }} />
                                            <label for="m8">{{ __('home.Aug') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m9" name="month" value="9" {{ ($currentMonth ==9 )?'checked':''; }} />
                                            <label for="m9">{{ __('home.Sep') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m10" name="month" value="10" {{ ($currentMonth ==10 )?'checked':''; }} />
                                            <label for="m10">{{ __('home.Oct') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m11" name="month" value="11" {{ ($currentMonth ==11 )?'checked':''; }} />
                                            <label for="m11">{{ __('home.Nov') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="m12" name="month" value="12" {{ ($currentMonth ==12 )?'checked':''; }} />
                                            <label for="m12">{{ __('home.Dec') }}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble yearLable">{{ __('home.Year') }}:</span>
                                <div class="yearDropdown">
                                    <button id="child2" data-bs-toggle="dropdown" class="form-select">{{ $currentYear }}</button>
                                    <ul class="dropdown-menu dropdown-menu-start guestAgeDropdownMenu">
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="id11" name="year" value="{{ $secondlastYear }}" />
                                            <label for="id11">{{ $secondlastYear }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="id22" name="year" value="{{ $lastYear }}" />
                                            <label for="id22">{{ $lastYear }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input class="rut_range" type="radio" id="id33" name="year" value="{{ $currentYear }}" checked/>
                                            <label for="id33">{{ $currentYear }}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="whitebox-w">
                    <!-- <img src="../images/product/chart1.png" class="cart"> -->
                    <div id="top_x_div" class="roomUtilizationChart"></div>
                </div>
                
                <div class="whitebox-w mb-0">
                    <h5 class="h5  mb-4">{{ __('home.YOYRevenue') }} </h5>
                    <div id="columnchart_material" class="revenueCahrt"></div>
                    <!-- <img src="{{asset('/assets/images/')}}/product/chart2.png" class="cart"> -->
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        var currentYear = "{{ $currentYear }}";
        var lastYear = "{{ $lastYear }}";
        var secondlastYear = "{{ $secondlastYear }}";
      
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($YOY); ?>);

            var options = {
                legend: {
                    position: 'left top'
                },
                width: "100%",
                bar: {
                    groupWidth: "35px"
                }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }



        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable(<?php echo json_encode($roomUtilizationRate); ?>);

            var options = {
                width: "100%",
                legend: {
                    position: 'bottom'
                },
                axes: {
                    x: {
                        0: {
                            side: 'bottom',
                            label: ''
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "35px"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            // Convert the Classic options to Material options.
            chart.draw(data, google.charts.Bar.convertOptions(options));
        };

        $(document).on('click','.rut_range',function(){
            var month = $('input[name=month]:checked').val();
            var year = $('input[name=year]:checked').val();
            if(month !='' && year !='')
            {
                loading();
                $.post("{{ route('room-utilization-rate') }}", {'_token': "{{ csrf_token() }}",'month':month,'year':year} , function( response ) {
                    // console.log(data);
                    var data = new google.visualization.arrayToDataTable(response);

                        var options = {
                            width: 1300,
                            legend: {
                                position: 'bottom'
                            },
                            axes: {
                                x: {
                                    0: {
                                        side: 'bottom',
                                        label: ''
                                    } // Top x-axis.
                                }
                            },
                            bar: {
                                groupWidth: "35px"
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                        // Convert the Classic options to Material options.
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    unloading();
                });                
            }
            else
            {
                unloading();
                $("#commonErrorMsg").text('Please select month and year');
                $("#commonErrorBox").css('display','block');
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 1500);
            }

        });
    </script>
 
