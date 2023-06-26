@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <div class="register-main-wrapper registerPage">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12 registerForm-col">
                    <div class="registerForw">
                        <h3 class="h3">{{ __('home.registerYourSelf') }}</h3>
                        <p class="p2">{{ __('home.pleaseFillIntheFormBelow') }}</p>
                        <form id="customer_signup_form" method="post">
                            <div class="form-floating" id="full_name_validate">
                                <input type="text" class="form-control onpress_enter " id="full_nameInput" placeholder="{{ __('home.fullName') }}" name="full_name" autocomplete="off">
                                <label for="full_nameInput">{{ __('home.fullName') }}<span class="required-star">*</span></label>
                                <p class="error-inp" id="full_name_err_msg"></p>
                            </div>
                            <div class="form-floating " id="email_validate">
                                <input type="text" class="form-control onpress_enter" id="emailInput" placeholder="name@example.com" value="" name="email" autocomplete="off">
                                <label for="emailInput">{{ __('home.email') }}<span class="required-star">*</span></label>
                                <p class="error-inp" id="email_err_msg"></p>
                            </div>
                            <div class="form-floating"  id="phone_validate">
                                <input type="text" class="form-control onpress_enter phone_number_input rightClickDisabled" id="phoneInput" placeholder="{{ __('home.phone') }}" name="phone">
                                <label for="phoneInput">{{ __('home.phone') }}<span class="required-star">*</span></label>
                                <p class="error-inp" id="phone_err_msg"></p>
                            </div>
                            <div class="form-floating" id="password_validate">
                                <input type="password" class="form-control onpress_enter" id="passwordInput" placeholder="{{ __('home.password') }}" name="password" autocomplete="off" >
                                <label for="passwordInput">{{ __('home.password') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="passwordInput" />
                                <p class="error-inp" id="password_err_msg"></p>
                            </div>
                            <div class="form-floating"  id="confirm_password_validate">
                                <input type="password" class="form-control onpress_enter" id="confirm_passwordInput" placeholder="{{ __('home.password') }}" name="confirm_password" autocomplete="off">
                                <label for="confirm_passwordInput">{{ __('home.confirmPassword') }}<span class="required-star">*</span></label>
                                <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="confirm_passwordInput" />
                                <p class="error-inp" id="confirm_password_err_msg"></p>
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
                            <div class="form-floating mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="regTnC" name="tnc">
                                    <label class="form-check-label" for="regTnC">{{ __('home.Iagree') }} <a href="{{ route('term_and_conditions') }}" target="_blank">{{ __('home.termsAndConditions') }}</a> & <a href="{{ route('term_and_conditions') }}"  target="_blank">Legal</a> and <a href="{{ route('privacy_policy') }}"  target="_blank">{{ __('home.securitySafetyPoilcies') }}</a>.</label>
                                    <p class="error-inp" id="regTnC_Error"></p>
                                    <p class="error-inp" id="server_err_msg"></p>
                                </div>
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div class="form-floating">
                                <a type="button" class="btn w-100" id="signup_submit">{{ __('home.register') }}</a>
                            </div>
                        </form>
                        <div class="or d-flex align-items-center justify-content-center"><span>or</span></div>
                        <div class="lgn-wt-btns d-flex">
                            <button class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/talk.svg')}}" class="" alt="talk"> Kakao</button>
                            <button class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/n.svg')}}" class="" alt="N"> Naver</button>
                        </div>
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
            //  alert('k');
            // console.log('kk-signup');
            //$('#signup_submit')[0].reset();
            $('#phoneInput').mask('000-0000-0000');
            $(document).on('keyup','.onpress_enter',function(e){
                $("#server_err_msg").text('');
                // console.log(e.keyCode);
                if(e.keyCode == 13)
                    registration_submit();
            });
            $(document).on('keyup','#full_nameInput',function(){
                $("#server_err_msg").text('');
                 if(field_required('full_name','full_nameInput',"Full name is required"))
                    if(!checkMaxLength($('#full_nameInput').val(),200 )) 
                        setErrorAndErrorBox('full_name','Full name should be less than 200 letters.'); 
                    else
                        unsetErrorAndErrorBox('full_name');
            });
            $(document).on('keyup','#emailInput',function(){
                $("#server_err_msg").text('');
                if(field_required('email','emailInput',"Email is required"))
                    if(!isEmail($('#emailInput').val())) 
                        setErrorAndErrorBox('email','Please enter a valid email.'); 
                    else
                    {
                        unsetErrorAndErrorBox('email'); 
                        // checkEmailIsExist($('#emailInput').val());
                    }
            });
            $(document).on('keyup','#phoneInput',function(){
                $("#server_err_msg").text('');
                if(field_required('phone','phoneInput',"Phone number is required"))
                    if(!checkExactLength($("#phoneInput").val(),13))
                            setErrorAndErrorBox('phone','Please enter a valid phone number.'); 
                        else
                            unsetErrorAndErrorBox('phone');    
            });
            $(document).on('keyup','#passwordInput',function(){
                $("#server_err_msg").text('');
                if(field_required('password','passwordInput',"Password is required"))
                {
                    if(!checkMinLength($('#passwordInput').val(),8 ))
                        setErrorAndErrorBox('password','Password should be minimum 8 letters.'); 
                    else
                        unsetErrorAndErrorBox('password');    
                }                
            });
            $(document).on('keyup','#confirm_passwordInput',function(){
                $("#server_err_msg").text('');
                if(field_required('confirm_password','confirm_passwordInput',"Confirm password is required"))
                {
                    if(!checkIsEqual($('#passwordInput').val(),$('#confirm_passwordInput').val()))
                        setErrorAndErrorBox('confirm_password','Password and confirm password should be same.'); 
                    else
                        unsetErrorAndErrorBox('confirm_password');        
                }
            });
            $(document).on('click','#regTnC',function(){
                isChecked("regTnC","Please accept terms and conditions.");
                $("#server_err_msg").text('');
            });
            $(document).on('click','#signup_submit',function(){
                registration_submit();
            });
        });
        function registration_submit()
        { 
            $("#server_err_msg").text('');
            var token=true; 
            if(!field_required('full_name','full_nameInput',"Full name is required"))
                token = false;
            else if(!checkMaxLength($('#full_nameInput').val(),200 )) 
            {
                setErrorAndErrorBox('full_name','Full name should be less than 200 letters.');
                token = false;
            }
            if(!field_required('email','emailInput',"Email is required"))
                token = false;
            else if(!isEmail($('#emailInput').val())) 
            {   
                setErrorAndErrorBox('email','Please enter a valid email.');
                token = false;
            }
            // else if(!checkEmailIsExist($('#emailInput').val()))
            //     token = false;
            if(!field_required('phone','phoneInput',"Phone number is required"))
                token = false;
            else if(!checkExactLength($("#phoneInput").val(),13))
            {   
                setErrorAndErrorBox('phone','Please enter a valid phone number.');
                token =false;  
            }
            else
                unsetErrorAndErrorBox('phone');
            if(!field_required('password','passwordInput',"Password is required"))
                token = false;
            else if(!checkMinLength($('#passwordInput').val(),8 )) 
            {   
                setErrorAndErrorBox('password','Password should be minimum 8 letters.');
                token = false;
            }
            if(!field_required('confirm_password','confirm_passwordInput',"Confirm password is required"))
                token = false;    
            else if(!checkIsEqual($('#passwordInput').val(),$('#confirm_passwordInput').val())) 
            {   
                setErrorAndErrorBox('confirm_password','Password and confirm password should be same.');
                token = false;
            }
            if(!isChecked("regTnC","Please accept term & conditions."))
                token =false;  
            if(token)
            {
                   $("#signup_submit").prop("disabled",true); 
                   loading();
                   var email = $('#emailInput').val();
                   $.post("{{ route('reg_emailcheck') }}",{email:email}, function(data){
                        if(data.status==0)
                        {
                            setErrorAndErrorBox('email',data.message);    
                            $("#signup_submit").prop("disabled",false); 
                            unloading(); 
                        }
                        else
                        {
                            $("#signup_submit").prop("disabled",true); 
                            $.post("{{ route('signup-submit') }}", $( "#customer_signup_form" ).serialize() , function( data ) {
                                // console.log(data);
                                if(data.nextpageurl !=undefined && data.nextpageurl !=''){
                                    $('#customer_signup_form')[0].reset();
                                    // $('#customer_signup_form').each(function(){
                                    //     this.reset();
                                    // });
                                    window.location.href = data.nextpageurl; 
                                }
                                else
                                {
                                    $("#server_err_msg").text('Something went wrong please try again.');
                                    $("#signup_submit").prop("disabled",false); 
                                }    
                                unloading();
                            });
                        }        
                    });
                   /* if(checkEmailIsExist($('#emailInput').val()))
                   {
                        $.post("{{ route('signup-submit') }}", $( "#customer_signup_form" ).serialize() , function( data ) {
                                console.log(data);
                                if(data.nextpageurl !=undefined && data.nextpageurl !=''){
                                    window.location.href = data.nextpageurl; 
                                }
                                else
                                {
                                    $("#server_err_msg").text('Something went wrong please try again.');
                                    $("#signup_submit").prop("disabled",false); 
                                }    
                                unloading();
                        });                    
                   }
                   else
                   {
                        $("#signup_submit").prop("disabled",false); 
                        unloading();
                   } */                  
            }
            else
            { 
                console.log('token'+token); 
            }
        }
    </script>   
    @endsection