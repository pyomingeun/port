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
                                <form id="facilities_input" method="post" action="javascript:void(0)">
                                    <div class="hotelManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt">
                                                <h5 class="hd5 h5">Facilities Manage</h5>
                                                <div class="row">
                                                   
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="facility_name_validate">
                                                            <input type="text" class="form-control a-enter-submit" id="facility_name" placeholder="Facilities Name" name="facility_name" value="{{(isset($facilitie->facility_name))?$facilitie->facility_name:''; }}"  >
                                                            <label for="facility_name">Facilities Name<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="facility_name_err_msg"></p>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{ (isset($facilitie->id)?$facilitie->id:0) }}" name="id" id="id">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <!-- <button type="button" class="btn bg-gray1 form_submit" data-btntype="save_n_exit" >Save & Exit</button> -->
                                        <button type="button" class="btn btnNext tab1 form_submit" data-btntype="next">Save</button>
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
@include('frontend.layout.footer_script')
@endsection

    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function(){

            // login 
            $(document).on('keyup','.f-enter-submit',function(e){
                // console.log(e.keyCode);
                if(e.keyCode == 13)
                submit();
            });


            $(document).on('keyup','#facility_name',function(){
                $('#hm_server_err_msg').text('');
                field_required('facility_name','facility_name',"Amenitie name is required");
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
          
                if(!field_required('facility_name','facility_name',"Amenitie name is required"))
                    token = false;
                else if(!checkMaxLength($('#facility_name').val(),200 )) 
                {
                    setErrorAndErrorBox('facility_name','Amenitie name should be less than 200 letters.');
                    token = false;
                }
                
                if(token)
                {
                   $(".form_submit").prop("disabled",true); 
                   loading();
                   
                    $(".form_submit").prop("disabled",true); 
                    $.post("{{ route('facilities-input-submit') }}", $( "#facilities_input" ).serialize() , function( data ) {
                        // console.log(data);
                        if(data.nextpageurl !=undefined && data.nextpageurl !=''){
                            window.location.href = data.nextpageurl; 
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
                        unloading();
                    });                   
                              
                }
            }
            // login close 

        });    
    </script>   
    @endsection
