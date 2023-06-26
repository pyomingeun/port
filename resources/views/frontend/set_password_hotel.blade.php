@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper update-password-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12 registerForm-col">
                    <div class="registerForw">
                        <h3 class="h3">{{ __('home.Set') }} {{ __('home.password') }}</h3>
                        <p class="p2 mb-1 sb-hdname"><span class="sb-hdname">Hi {{$user->full_name}}</span></p>
                        <p class="p2 mb-1">{{ __('home.pleaseSetThePasswordForYour') }} {{ __('home.registeredemailaddress') }}
                        </p>
                         <p class="p2">{{$user->email}}.</p>
                         <?php /*    
                        <p class="p2"><span class="sb-hdname text-capitalize">Hi {{$user->full_name}}</span> Please set the password for your registered email address {{$user->email}}.
                        </p> */ ?>
                        <form action="javaScript:Void(0);" method="post" id="set_password_form">
                            <!-- <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">New Password<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/')}}/structure/eye-icon-hide.svg" alt="eye-icon" class="eye-icon" />
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="cfloatingPassword" placeholder="Password">
                                <label for="cfloatingPassword">Confirm Password<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/')}}/structure/eye-icon-hide.svg" alt="eye-icon" class="eye-icon" />
                            </div> -->
                            <div class="form-floating"  id="set_new_password_validate">
                                <input type="password" class="form-control onentersubmit_setpass" id="set_new_password" placeholder="{{ __('home.password') }}" name="set_new_password" autocomplete="off">
                                <label for="set_new_password">{{ __('home.newPassword') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="set_new_password"  />
                                <p class="error-inp" id="set_new_password_err_msg"></p>
                            </div>
                            <div class="form-floating" id="set_confirm_password_validate">
                                <input type="password" class="form-control onentersubmit_setpass" id="set_confirm_password" placeholder="{{ __('home.confirmPassword') }}"  name="set_confirm_password" autocomplete="off">
                                <label for="set_confirm_password">{{ __('home.confirmPassword') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="set_confirm_password" />
                                <p class="error-inp" id="set_confirm_password_err_msg"></p>
                                <p class="error-inp" id="set_password_server_err_msg"></p>
                            </div>
                            <?php /* 
                            <div class="password-instruction">
                                <p class="p2 checked-ins">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-green.svg" alt="Check" class="passInsIcon" />One lowercase character
                                </p>
                                <p class="p2 checked-ins">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-green.svg" alt="Check" class="passInsIcon" />One special character
                                </p>
                                <p class="p2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />One uppercase character
                                </p>
                                <p class="p2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />8 characters minimum
                                </p>
                                <p class="p2">
                                    <img src="{{asset('/assets/images/')}}/structure/check-circle-gray.svg" alt="Check" class="passInsIcon" />Passwords match
                                </p>
                            </div>
                            */ ?>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <input type="hidden" value="{{ $user->set_password_code }}" name="code">
                            <div class="form-floating mt-4">
                            <a type="button" class="btn" id="set_password_submit">{{ __('home.getStarted') }}</a>
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
            $(document).on('click','#set_password_submit',function(){
                $('#set_password_server_err_msg').text('');
                setPasswordSubmit();                
            });
            $(document).on('keyup','.onentersubmit_setpass',function(e){
                if(e.keyCode == 13)  
                setPasswordSubmit();
            });
            $(document).on('keyup','#set_new_password',function(){
                $("#set_password_server_err_msg").text('');
                if(field_required('set_new_password','set_new_password',"Password is required"))
                {
                    if(!checkMinLength($('#set_new_password').val(),8 ))
                        setErrorAndErrorBox('set_new_password','Password should be minimum 8 letters.'); 
                    else
                        unsetErrorAndErrorBox('set_new_password');    
                }                
            });
            $(document).on('keyup','#set_confirm_password',function(){
                $("#set_password_server_err_msg").text('');
                if(field_required('set_confirm_password','set_confirm_password',"Confirm password is required"))
                {
                    if(!checkIsEqual($('#set_new_password').val(),$('#set_confirm_password').val()))
                        setErrorAndErrorBox('set_confirm_password','Password and confirm password should be same.'); 
                    else
                        unsetErrorAndErrorBox('set_confirm_password');        
                }
            });
            function setPasswordSubmit()
            { 
                var token=true; 
                if(!field_required('set_new_password','set_new_password',"Password is required"))
                    token = false;
                else if(!checkMinLength($('#set_new_password').val(),8)) 
                {   
                    setErrorAndErrorBox('set_new_password','Password should be minimum 8 letters.');
                    token = false;
                }
                if(!field_required('set_confirm_password','set_confirm_password',"Confirm password is required"))
                    token = false;    
                else if(!checkIsEqual($('#set_new_password').val(),$('#set_confirm_password').val())) 
                {   
                    setErrorAndErrorBox('set_confirm_password','Password and confirm password should be same.');
                    token = false;
                }
                if(token)
                {
                    $("#set_password_submit").prop("disabled",true); 
                    loading();
                    $.post("{{ route('set_password') }}", $( "#set_password_form" ).serialize() , function( data ) {
                                // console.log(data);
                                if(data.status==1){
                                    window.location.href = data.nextpageurl; 
                                    unloading();
                                } 
                                else
                                {
                                    $("#set_password_submit").prop("disabled",false); 
                                    $('#set_password_server_err_msg').text(data.message);
                                }                           
                                unloading();
                    });             
                }
            }
        });    
    </script>   
    @endsection