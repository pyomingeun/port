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
            <h5 class="h5  mb-0">{{ __('home.couponCode') }}</h5>
            <form action="" method="post" id="cpn_lsiting">
                <div class="heading-sec mb-4 d-flex align-items-center">
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        @if(auth()->user()->access =='admin')
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">{{ __('home.HotelList') }}</span>
                                <div class="">
                                    <button id="child1" data-bs-toggle="dropdown" class="form-select text-capitalize">{{ (isset($hname) && $hname !='')?$hname:'All'; }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image">
                                            <input type="radio" id="h" name="h" value="" class="hmfilter_by_h" {{ (isset($h) && $h=='' )?'checked':'' }} />
                                            <label for="h">{{ __('home.All') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input type="radio" id="h0" name="h" value="0" class="hmfilter_by_h" {{ (isset($h) && $h=='0' )?'checked':'' }} />
                                            <label for="h0">For all hotel</label>
                                        </li>
                                        @foreach ($hotels as $hotel)
                                        <li class="radiobox-image">
                                            <input type="radio" id="h_{{ $hotel->slug }}" name="h" value="{{ $hotel->slug }}" class="hmfilter_by_h" {{ (isset($h) && $h==$hotel->slug )?'checked':'' }} />
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
                                <span class="ddLAble monthLable">{{ __('home.discountType') }}</span>
                                <div class="">
                                    <button id="child1" data-bs-toggle="dropdown" class="form-select text-capitalize">{{ (isset($dtype) && $dtype!='')?str_replace("_"," ",$dtype):'All' }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image">
                                            <input type="radio" id="dtype_all" name="dtype" value="" class="hmfilter_by_dtype" {{ (isset($dtype) && $dtype=='')?'checked':'' }} />
                                            <label for="dtype_all">{{ __('home.All') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input type="radio" id="dtype_fixed_amount" name="dtype" value="fixed_amount" class="hmfilter_by_dtype" {{ (isset($dtype) && $dtype=='fixed_amount')?'checked':'' }} />
                                            <label for="dtype_fixed_amount">{{ __('home.fixedAmount') }}</label>
                                        </li>
                                        <li class="radiobox-image">
                                            <input type="radio" id="dtype_percentage" name="dtype" value="percentage" class="hmfilter_by_dtype" {{ (isset($dtype) && $dtype=='percentage')?'checked':'' }}/>
                                            <label for="dtype_percentage">{{ __('home.percentage') }}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                         <a  href="{{ route('coupon-list') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <input type="hidden" name="c" id="c" value="{{ (isset($c))?$c:''; }}">
                        <input type="hidden" name="o" id="o" value="{{ (isset($o))?$o:''; }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                        <div class="filter-header-col">
                            <a href="{{ route('coupon-input','new')}}" class="btn h-36">{{ __('home.createCoupon') }}</a>
                        </div>
                    </div>
                    </form>
                </div>
                @if(count($coupons) == 0 )
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/coupon-code-empt-img.png" alt="" class="empty-list-image">
                        <h6>Your coupon code list is empty</h6>
                        <p class="p3 mb-4">Add coupon code now by clicking on below button.</p>
                        <!-- <a href="{{ route('coupon-input','new')}}" class="btn">Create Coupon</a> -->
                    </div>
                </div>
                @endif
                @if(count($coupons) > 0 )
                <div class="tableboxpadding0">
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    @if(auth()->user()->access =='admin') 
                                    <th>
                                       <p>
                                            Hotel Name 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='hotel_info.hotel_name' && $o=='desc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='hotel_info.hotel_name' && $o=='asc')?'hidesorticon':''; }}" data-c="hotel_info.hotel_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    @endif                                
                                    <th>
                                        <p>
                                            Coupon Code
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.coupon_code_name' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.coupon_code_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.coupon_code_name' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.coupon_code_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Discount Type
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.discount_type' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.discount_type" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.discount_type' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.discount_type" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Discount
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.discount_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.discount_amount" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.discount_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.discount_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Max Discount<br> Amount
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.max_discount_amount' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.max_discount_amount" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.max_discount_amount' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.max_discount_amount" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Expiry Date
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.expiry_date' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.expiry_date" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.expiry_date' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.expiry_date" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Usage Limit
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.limit_per_user' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.limit_per_user" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.limit_per_user' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.limit_per_user" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            No of Coupon<br> to be Used
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.available_no_of_coupon_to_use' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.available_no_of_coupon_to_use" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.available_no_of_coupon_to_use' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.available_no_of_coupon_to_use" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Status
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='coupons.status' && $o=='desc')?'hidesorticon':''; }}" data-c="coupons.status" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='coupons.status' && $o=='asc')?'hidesorticon':''; }}" data-c="coupons.status" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>            
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                @php
                                    $expiry_date=date_create($coupon->expiry_date);
                                @endphp
                                <tr>
                                    @if(auth()->user()->access =='admin')
                                    <td>{{ ($coupon->hotel_name !=null && $coupon->hotel_name !='')?$coupon->hotel_name:'For all hotel'; }}</td>
                                    @endif
                                    <td>{{ $coupon->coupon_code_name }}</td>
                                    <td class="text-capitalize">{{ str_replace("_"," ",$coupon->discount_type); }}</td>
                                    <td>{{ ($coupon->discount_type == 'fixed_amount')?'₩ '.$coupon->discount_amount:$coupon->discount_amount.'%';  }}</td>
                                    <td>{{ '₩ '.$coupon->max_discount_amount;  }}</td>
                                    <td>{{   date_format($expiry_date,"Y-m-d") }}</td>
                                    <td>{{ $coupon->limit_per_user }} time/guest</td>
                                    <td>{{ $coupon->available_no_of_coupon_to_use }}</td>
                                    <td class="text-capitalize">{{ $coupon->status }}</td>
                                    <td class="actionDropdown">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('coupon-input',$coupon->slug)}}"><img src="{{asset('/assets/images/')}}/structure/edit.svg" alt="" class="editIcon">Edit</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delCoupon" href="" data-i="{{ $coupon->slug }}" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon">Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
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
                {{$coupons->appends(Request::only(['search','hotel']))->links('pagination::bootstrap-4')}}
            </div>
        </div>
        <!--Delete Modal -->
        <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-heads">
                            <h3 class="h3 mt-2">Delete Coupon Code</h3>
                            <p class="p2 mb-4">Are you sure you want to delete this coupon code?</p>
                        </div>
                        <div class="d-flex btns-rw">
                            <button class="btn bg-gray flex-fill" id="couponDelYes" data-i="0">Yes</button>
                            <button class="btn flex-fill" data-bs-dismiss="modal">No</button>
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
    $(document).ready(function() {
        $(document).on('click','.sortdata',function(){
            var o = $(this).attr('data-o');
            var c = $(this).attr('data-c');
            $("#c").val(c);     
            $("#o").val(o);     
            $( "#cpn_lsiting" ).submit();
        });
        $(document).on('click','.hmfilter_by_dtype',function(){
            $(this).attr('checked', true);
            $( "#cpn_lsiting" ).submit();
        });
        $(document).on('click','.hmfilter_by_h',function(){
            $(this).attr('checked', true);
            $( "#cpn_lsiting" ).submit();
        });
        // delete account 
        $(document).on('click','.delCoupon',function(){
            var i = $(this).attr('data-i');
            $("#couponDelYes").attr('data-i',i);                
        });            
        $(document).on('click','#couponDelYes',function(){
            var i = $(this).attr('data-i');
            var url = "{{ route('del-coupon',['slug'=>':i'])}}";  
            url = url.replace(':i', i);
            // alert(url); 
            window.location.href = url;
        });
    });
</script>
@endsection