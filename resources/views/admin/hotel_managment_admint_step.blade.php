@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->
        
    <div class="main-wrapper-gray">
         @include('admin.leftbar')        
        <div class="content-box-right hotel-management-sec">

            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                   
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <div class="">
                                <form id="admin_hotel_setup" method="post">
                                    <div class="hotelManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">Hotel Info</h5>
                                                <div class="row">
                                                   
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="hotel_email_validate">
                                                            <input type="text" class="form-control" id="hotel_email" placeholder="Hotel Email" name="hotel_email">
                                                            <label for="hotel_email">Hotel Email<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="hotel_email_err_msg"></p>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="hotel_name_validate">
                                                            <input type="text" class="form-control" id="hotel_name" placeholder="Hotel Name" name="hotel_name">
                                                            <label for="hotel_name">Hotel Name<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="hotel_name_err_msg"></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <button type="button" class="btn bg-gray1 form_submit" data-btntype="save_n_exit" >Save & Exit</button>
                                        <button type="button" class="btn btnNext tab1 form_submit" data-btntype="next">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

            // login 
            $(document).on('keyup','.onpress_enter_login',function(e){
                // console.log(e.keyCode);
                if(e.keyCode == 13)
                submit();
            });

            $(document).on('keyup','#hotel_email',function(){
                $("#hm_server_err_msg").text('');
                if(field_required('hotel_email','hotel_email',"Email is required"))
                    if(!isEmail($('#hotel_email').val())) 
                        setErrorAndErrorBox('hotel_email','Please enter a valid email.'); 
                    else
                    {
                        unsetErrorAndErrorBox('hotel_email'); 
                        checkEmailIsExist($('#hotel_email').val());
                    }
            });

            $(document).on('keyup','#hotel_name',function(){
                $('#hm_server_err_msg').text('');
                field_required('hotel_name','hotel_name',"Hotel name is required");
            });

            $(document).on('click','.form_submit',function(){
                $('#hm_server_err_msg').text('');
                $('#savetype').val($(this).attr('data-btntype')); 
                submit();
            });
                
            
            function submit()
            { 
                $("#hm_server_err_msg").text('');
                var token=true; 
            
                
                if(!field_required('hotel_email','hotel_email',"Email is required"))
                    token = false;
                else if(!isEmail($('#hotel_email').val())) 
                {   
                    setErrorAndErrorBox('hotel_email','Please enter a valid email.');
                    token = false;
                }

                if(!field_required('hotel_name','hotel_name',"Hotel name is required"))
                    token = false;
                else if(!checkMaxLength($('#hotel_name').val(),200 )) 
                {
                    setErrorAndErrorBox('hotel_name','Hotel name should be less than 200 letters.');
                    token = false;
                }
                
                if(token)
                {
                    $(".form_submit").prop("disabled",true); 
                   loading();
                   var email = $('#hotel_email').val();
                   $.post("{{ route('reg_emailcheck') }}",{email:email}, function(data){
                        if(data.status==0)
                        {
                            setErrorAndErrorBox('hotel_email',data.message);    
                            $(".form_submit").prop("disabled",false); 
                            unloading(); 
                        }
                        else
                        {
                            $(".form_submit").prop("disabled",true); 
                            $.post("{{ route('hotel_setup_submit') }}", $( "#admin_hotel_setup" ).serialize() , function( data ) {
                                // console.log(data);
                                if(data.nextpageurl !=undefined && data.nextpageurl !=''){
                                    window.location.href = data.nextpageurl; 
                                }
                                else
                                {
                                    $("#hm_server_err_msg").text('Something went wrong please try again.');
                                    $(".form_submit").prop("disabled",false); 
                                }    
                                unloading();
                            });
                        }        

                    });             
                }
            }
            // login close 

        });    
    </script>   
    @endsection
