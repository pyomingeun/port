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
            <h5 class="h5  mb-0">Rating & Reviews</h5>
            <form action="" method="post" id="cpn_lsiting">
                <div class="heading-sec mb-4 d-flex align-items-center">
                   
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        @if(auth()->user()->access =='admin')
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <div class="form-floating mb-0">
                                <span class="ddLAble monthLable">Hotel List</span>
                                <div class="">
                                    <button id="child1" data-bs-toggle="dropdown" class="form-select text-capitalize">{{ (isset($hname) && $hname !='')?$hname:'All'; }}</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="radiobox-image">
                                            <input type="radio" id="h" name="h" value="" class="hmfilter_by_h" {{ (isset($h) && $h=='' )?'checked':'' }} />
                                            <label for="h">All</label>
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
                         <a  href="{{ route('rating-review-list') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <input type="hidden" name="c" id="c" value="{{ (isset($c))?$c:''; }}">
                        <input type="hidden" name="o" id="o" value="{{ (isset($o))?$o:''; }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">

                    </div>
                    </form>
                </div>
                @if(count($ratingRevies) == 0 )
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/coupon-code-empt-img.png" alt="" class="empty-list-image">
                        <h6>Not found any rating-revies </h6>
                    </div>
                </div>
                @endif
                @if(count($ratingRevies) > 0 )
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
                                            Customer Name  
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='user.full_name' && $o=='desc')?'hidesorticon':''; }}" data-c="user.full_name" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='user.full_name' && $o=='asc')?'hidesorticon':''; }}" data-c="user.full_name" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Cleanliness
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.cleanliness' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.cleanliness" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.cleanliness' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.cleanliness" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Facilities
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.facilities' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.facilities" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.facilities' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.facilities" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Service
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.service' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.service" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.service' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.service" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Value For</br>Money
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.value_for_money' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.value_for_money" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.value_for_money' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.value_for_money" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Avg Rating
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.avg_rating' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.avg_rating" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.avg_rating' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.avg_rating" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <th>
                                        <p>
                                            Review
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata  {{ ($c=='rating_reviews.review' && $o=='desc')?'hidesorticon':''; }}" data-c="rating_reviews.review" data-o="asc" ></i>
                                                <i class="fa fa-caret-up arrow-down sortdata  {{ ($c=='rating_reviews.review' && $o=='asc')?'hidesorticon':''; }}" data-c="rating_reviews.review" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
           
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ratingRevies as $row)
                                @php
                                    $expiry_date=date_create($row->expiry_date);
                                @endphp
                                <tr>
                                    @if(auth()->user()->access =='admin')
                                    <td>{{ $row->hotel_name }}</td>
                                    @endif
                                    <td>{{ $row->full_name }}</td>
                                    <td>{{ $row->cleanliness }}</td>
                                    <td>{{ $row->facilities }}</td>
                                    <td>{{ $row->service }}</td>
                                    <td>{{ $row->value_for_money }}</td>
                                    <td>{{ $row->avg_rating }}</td>
                                    <td title="{{ $row->review }}"><div class="review-td-scroll">{{ $row->review }}</div></td>
                                    <td class="actionDropdown">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item delRR" href="" data-i="{{ $row->id}}" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon">Delete</a>
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
                {{$ratingRevies->appends(Request::only(['search','hotel']))->links('pagination::bootstrap-4')}}
            </div>
        </div>

        <!--Delete Modal -->
        <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-heads">
                            <h3 class="h3 mt-2">Delete Rating-Review</h3>
                            <p class="p2 mb-4">Are you sure you want to delete this rating-review?</p>
                        </div>
                        <div class="d-flex btns-rw">
                            <button class="btn bg-gray flex-fill" id="RRDelYes" data-i="0">Yes</button>
                            <button class="btn flex-fill" data-bs-dismiss="modal">No</button>
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
        $(document).on('click','.delRR',function(){
            var i = $(this).attr('data-i');
            $("#RRDelYes").attr('data-i',i);                
        });            
        $(document).on('click','#RRDelYes',function(){
            var i = $(this).attr('data-i');
            var url = "{{ route('del-ratingreview',['id'=>':i']) }}";  
            url = url.replace(':i', i);
            // alert(url); 
            window.location.href = url;
        });

    });
</script>
@endsection