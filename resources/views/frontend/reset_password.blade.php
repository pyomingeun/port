@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper update-password-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12 registerForm-col">
                    <div class="registerForw">
                        <h3 class="h3">{{ __('home.updatePassword') }}</h3>
                        <p class="p2">{{ __('home.pleaseEnterBelowDetailsToUpdateYourPassword') }}</p>
                        <form action="javaScript:Void(0);" method="post" id="reset_password_form">
                            <div class="form-floating"  id="reset_new_password_validate">
                                <input type="password" class="form-control onentersubmit_resetpass" id="reset_new_password" placeholder="{{ __('home.password') }}" name="reset_new_password">
                                <label for="reset_new_password">{{ __('home.newPassword') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="reset_new_password"  />
                                <p class="error-inp" id="reset_new_password_err_msg"></p>
                            </div>
                            <div class="form-floating" id="reset_confirm_password_validate">
                                <input type="password" class="form-control onentersubmit_resetpass" id="reset_confirm_password" placeholder="{{ __('home.confirmPassword') }}"  name="reset_confirm_password">
                                <label for="reset_confirm_password">{{ __('home.confirmPassword') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="reset_confirm_password" />
                                <p class="error-inp" id="reset_confirm_password_err_msg"></p>
                                <p class="error-inp" id="reset_password_server_err_msg"></p>
                            </div>
                            <?php /* 
                            <div class="password-instruction">
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/structure/check-circle-green.svg')}}" alt="Check" class="passInsIcon" />One lowercase character
                                </p>
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/structure/check-circle-green.svg')}}" alt="Check" class="passInsIcon" />One special character
                                </p>
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />One uppercase character
                                </p>
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />8 characters minimum
                                </p>
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />Passwords match
                                </p>
                            </div>
                            */ ?>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <input type="hidden" value="{{ $user->forgot_password_code }}" name="code">
                            <div class="form-floating mt-4">
                                <a type="button" class="btn" id="reset_password_submit">{{ __('home.update') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- offer image div -->
                @include('frontend.layout.offer_promotion')
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
            // console.log('kk-common');
            $(document).on('click','#reset_password_submit',function(){
                $('#reset_password_server_err_msg').text('');
                resetPasswordSubmit();                
            }); 
            $(document).on('keyup','.onentersubmit_resetpass',function(e){
                if(e.keyCode == 13)  
                  resetPasswordSubmit();
            });
            $(document).on('keyup','#reset_new_password',function(){
                $("#reset_password_server_err_msg").text('');
                if(field_required('reset_new_password','reset_new_password',"Password is required"))
                {
                    if(!checkMinLength($('#reset_new_password').val(),8 ))
                        setErrorAndErrorBox('reset_new_password','Password should be minimum 8 letters.'); 
                    else
                        unsetErrorAndErrorBox('reset_new_password');    
                }                
            });
            $(document).on('keyup','#reset_confirm_password',function(){
                $("#reset_password_server_err_msg").text('');
                if(field_required('reset_confirm_password','reset_confirm_password',"Confirm password is required"))
                {
                    if(!checkIsEqual($('#reset_new_password').val(),$('#reset_confirm_password').val()))
                        setErrorAndErrorBox('reset_confirm_password','Password and confirm password should be same.'); 
                    else
                        unsetErrorAndErrorBox('reset_confirm_password');        
                }
            });
            function resetPasswordSubmit()
            { 
                var token=true; 
                if(!field_required('reset_new_password','reset_new_password',"Password is required"))
                    token = false;
                else if(!checkMinLength($('#reset_new_password').val(),8)) 
                {   
                    setErrorAndErrorBox('reset_new_password','Password should be minimum 8 letters.');
                    token = false;
                }
                if(!field_required('reset_confirm_password','reset_confirm_password',"Confirm password is required"))
                    token = false;    
                else if(!checkIsEqual($('#reset_new_password').val(),$('#reset_confirm_password').val())) 
                {   
                    setErrorAndErrorBox('reset_confirm_password','Password and confirm password should be same.');
                    token = false;
                }
                if(token)
                {
                    $("#reset_password_submit").prop("disabled",true); 
                    loading();
                    $.post("{{ route('update_password') }}", $( "#reset_password_form" ).serialize() , function( data ) {
                                // console.log(data);
                                if(data.status==1){
                                    window.location.href = data.nextpageurl; 
                                    unloading();
                                } 
                                else
                                {
                                    $("#reset_password_submit").prop("disabled",false); 
                                    $('#reset_password_server_err_msg').text(data.message);
                                }                           
                                unloading();
                    });             
                }
            }
        });    
    </script>   
    @endsection    