@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->

    <div class="main-wrapper-gray">
        @include('admin.leftbar')
        <div class="content-box-right my-rewards-sec">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-12 col-md-4 col-md-12 col-sm-4 col-12 rewards-main-block">
                        <div class="rewards-inner-block">
                            <p class="p3">Rewards</p>
                            <div class="d-flex align-items-center">
                                <img src="{{asset('/assets/images/')}}/structure/stars-circle-blue.svg" alt="" class="m-r-rewalrdIcon">
                                <div>
                                    <h3 class="h3">{{ $user->total_rewards_points; }}</h3>
                                    <p class="p2">Total Reward Earn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-8 col-md-12 col-sm-8 col-12 grab-rewards-hotel-booking">
                        <div class="grab-rewards-hotel-booking-inner-box d-flex align-items-center">
                            <!-- <form action="javaScript:void(0);" class="w-100" method="post" id="rp_form">
                                <div class="filter-header-row ml-auto d-flex justify-content-center">
                               
                                    <h6 class="h6 mb-0 pt-3">Credit/Debit Reward Points</h6>
                                    <div class="filter-header-col h-56 ms-3" id="reward_points_validate">
                                        <input type="text" class="form-control onpress_enter_rp only_integer" placeholder="Reward Points"  name="reward_points" value="" id="reward_points" />
                                        <p class="error-inp" id="reward_points_err_msg">646465464</p>
                                    </div>
                                    <div class="filter-header-col h-56 ms-3">
                                        <div class="form-floating mb-0">
                                            <div class="">
                                                <button type="button" id="child1" data-bs-toggle="dropdown" class="form-select">Debit</button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li class="radiobox-image">
                                                        <input class="hmfilter_by_status" type="radio" id="debit" name="rtype" value="debited" checked />
                                                        <label for="debit">Debit</label>
                                                    </li>
                                                    <li class="radiobox-image">
                                                        <input class="hmfilter_by_status" type="radio" id="credit" name="rtype" value="credited"  />
                                                        <label for="credit">Credit</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $id }}"> 
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">                                       
                                    <div class="filter-header-col h-56 ms-3">
                                        
                                    </div>
                                </div>
                            </form> -->
                            <div class="d-flex justify-content-between w-100">
                                <h4 class="h4 mb-0 text-capitalize" >{{ $user->full_name; }}</h4>
                                <button class="btn" type="button" data-bs-toggle="modal" data-bs-target=".Credit_DebitRewardPointsDialog">Credit/Debit Reward Points</button>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($rewards) ==0)
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/rewards-empty-img.png" alt="" class="empty-list-image">
                        <h6>empty-list</h6>
                        <!-- <p class="p3">Book hotel and earn many rewards points for your future bookings.</p> -->
                    </div>
                </div>
                @else
                <div class="whitebox-w rewardHistorybox-w mt-4">
                    <h6 class="h6">Reward History</h6>
                    @php
                    $tmpDate ='';
                    $tmpDate2 ='';
                    $rewardsCounter = count($rewards);  
                    @endphp
                    
                    @for($i=0; $i<$rewardsCounter; $i++)
                        @if($tmpDate != $rewards[$i]->transaction_on)
                        <div class="rewardHistorybox">
                        <p class="p3">{{ $rewards[$i]->transaction_on }}</p>
                        @endif
                       
                        @php
                        $tmpDate = $rewards[$i]->transaction_on;
                        $tmpDate2 = (isset($rewards[$i+1]->transaction_on))?$rewards[$i+1]->transaction_on:'';
                        @endphp
                            <div class="row">
                                <div class="col-xl-9 col-lg-9 col-md-9 col-md-9 col-sm-9 col-12">
                                    <div class="rewardHistoryIcnNmBox">
                                        <img src="{{asset('/assets/images/')}}/structure/points-{{ $rewards[$i]->reward_type }}.svg" class="rewHisIcon">
                                        <div>
                                            <h6 class="h6">{{ $rewards[$i]->title }}</h6>
                                            <p class="p3 mb-0">{{ $rewards[$i]->message }}<span> {{ ($rewards[$i]->booking_slug !='')?"{".$rewards[$i]->booking_slug."}":'';  }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-sm-3 col-12">
                                    <p class="p1 points-{{ $rewards[$i]->reward_type }}">{{ ($rewards[$i]->reward_type =='credited')?'+':'-'; }} {{ $rewards[$i]->reward_points }}  points</p>
                                </div>
                            </div>
                        @if($tmpDate != $tmpDate2)
                        </div>
                        @endif
                    
                    @endfor
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Forgot password -->
    <div class="modal fade Credit_DebitRewardPointsDialog" tabindex="-1" aria-labelledby="Credit_DebitRewardPointsDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-heads">
                    <h3 class="h3">Credit/Debit Reward Points</h3>
                    <!-- <p class="p2">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p> -->
                </div>
                <form  action="javaScript:void(0);" method="post" id="rp_form" >
                    <div class="form-floating" id="title_validate">
                        <input type="text" class="form-control onpress_enter_rp" placeholder="Title"  name="title" value="" id="title" />
                        <label for="title">Title<span class="required-star">*</span></label>
                        <p class="error-inp" id="title_err_msg"></p>
                    </div>
                    <div class="form-floating" id="message_validate">
                        <input type="text" class="form-control" placeholder="Message" id="message" />
                        <label for="message">Message<span class="required-star">*</span></label>
                        <p class="error-inp" id="message_err_msg"></p>
                    </div>
                    <div class="h-56 mb-4">
                        <div class="form-floating">
                            <div class="">
                                <button type="button" id="child1" data-bs-toggle="dropdown" class="form-select">Debit</button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="radiobox-image">
                                        <input class="hmfilter_by_status" type="radio" id="debit" name="rtype" value="debited" checked />
                                        <label for="debit">Debit</label>
                                    </li>
                                    <li class="radiobox-image">
                                        <input class="hmfilter_by_status" type="radio" id="credit" name="rtype" value="credited"  />
                                        <label for="credit">Credit</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="quantity-row d-flex align-items-center mb-4">
                        <p class="p2 mb-0">Reward Points</p>
                        <div class="quantity-box d-flex align-items-center ml-auto">
                            <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                            <input type="text" value="1" class="only_integer setminval" id="reward_points "name="reward_points" data-minval="1"/>
                            <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                            <!-- <p class="error-inp" id="reward_points_err_msg"></p> -->
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $id }}"> 
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">                                       
                    <div class="h-56">
                        <button class="btn form_submit w-100" type="button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- close -->
<!-- common models -->
@include('common_models')

@include('frontend.layout.footer_script')
@endsection

<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        
        $(document).on('click','.form_submit',function(){
            submit();
        });

        //submit  
        $(document).on('keyup','.onpress_enter_rp',function(e){
            // console.log(e.keyCode);
            if(e.keyCode == 13)
            submit();
        });

        $(document).on('keyup','#title',function(){
            field_required('title','title',"Title is required");
        });

        $(document).on('keyup','#message',function(){
            field_required('message','message',"Message is required");
        });        

        function submit()
        { 
            var token=true; 
            $(".form_submit").prop("disabled",true); 
                   loading();
            if(!field_required('title','title',"Title is required"))
                token = false;

            if(!field_required('message','message',"Message is required"))
                token = false;    
            
            /* if($('#reward_points').val() < 1)
                 setErrorAndErrorBox('reward_points','Reward points should be greater than 1.');
            else
                unsetErrorAndErrorBox('reward_points'); */       

            if(token)
            {
                 $.post("{{ route('credit-debit-reward') }}",$( "#rp_form" ).serialize(), function(data){
                    if(data.status==1)
                    {
                        unloading();
                        $('#rp_form')[0].reset();
                        $('#reward_points').val('1');
                        location.reload();
                    }
                    else
                    {
                        $("#commonErrorMsg").text(data.message);
                        $("#commonErrorBox").css('display','block');
                        $(".form_submit").prop("disabled",false); 
                        unloading();
                        setTimeout(function() {
                            $("#commonSuccessBox").hide();
                        }, 3000);
                    }
                });                                  
            }
            else
            {
                $(".form_submit").prop("disabled",false); 
                unloading();
            }
        }        

     });    
</script>   
@endsection