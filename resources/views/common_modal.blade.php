    <!-- Login modeal -->
    <div class="modal fade loginDialog" tabindex="-1" aria-labelledby="loginDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads text-center" style="margin-bottom: 20px;">
                        <h3 class="h3">L O G I N</h3>
                        <p2 class="p2">{{ __('home.LogIn') }}</p2>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="login_form">
                        <div class="form-floating-mb18" id="loginemail_validate">
                            <input type="email" class="form-control onpress_enter_login" id="loginemail"  autocomplete="off" name="loginemail" required placeholder="{{ __('home.Email') }}">
                            <p class="error-inp" id="loginemail_err_msg"></p>
                        </div>
                        <div class="form-floating-mb18" id="loginpassword_validate">
                            <input type="password" class="form-control onpress_enter_login" id="loginpassword"  autocomplete="off" name="loginpassword" required placeholder="{{ __('home.Password') }}">
                            <p class="error-inp" id="loginpassword_err_msg"></p>
                            <p class="error-inp" id="login_server_err_msg"></p>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <input type="hidden" value="{{ url()->full(); }}" name="nexturl" id="nexturl">
                        <div class="form-floating-mb12">
                            <button type="button" class="btn bg-black w-100" id="login_submit">{{ __('home.LogIn') }}</button>
                        </div>
                        <div class="form-floating-mb12">
                            <button type="button" class="btn bg-white w-100" data-bs-toggle="modal" data-bs-target=".signupDialog">{{ __('home.SignUp') }}</button>
                        </div>
                        <p class="forgotPass-link text-end"><a href="#" data-bs-toggle="modal" data-bs-target=".forgotPassDialog" data-bs-dismiss="modal">{{ __('home.ForgotPassword') }}</a></p>
                        <p class="p3 text-center">{{ __('home.SNSLogin') }}</p>
                        <div class="lgn-wt-btns d-flex">
                            <a href="{{route('login-kakao')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/talk.svg')}}" alt="talk" class=""> Kakao</a>
                            <a href="{{route('login-naver')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/n.svg')}}" alt="N" class=""> Naver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup modeal -->
    <div class="modal fade signupDialog" tabindex="-1" aria-labelledby="SignupDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads text-center" style="margin-bottom: 20px;">
                        <h3 class="h3">S I G N - U P</h3>
                        <p2 class="p2">{{ __('home.SignUp') }}</p2>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="customer_signup_form">
                        <div class="form-floating-mb18" id="full_name_validate">
                            <input type="text" class="form-control onpress_enter" id="full_nameInput"  autocomplete="off" name="full_name" placeholder="{{ __('home.Name') }}" required>
                            <p class="error-inp" id="full_name_err_msg"></p>
                        </div>
                        <div class="form-floating-mb18" id="email_validate">
                            <input type="email" class="form-control onpress_enter" id="emailInput"  autocomplete="off" name="email" placeholder="{{ __('home.Email') }}" required>
                            <p class="error-inp" id="email_err_msg"></p>                            
                        </div>
                        <div class="form-floating-mb18" id="phone_validate">
                            <input type="text" class="form-control onpress_enter phone_number_input rightClickDisabled" id="phoneInput"  autocomplete="off" name="phone" placeholder="{{ __('home.Mobile') }}" required>
                            <p class="error-inp" id="phone_err_msg"></p>                            
                        </div>
                        <div class="form-floating-mb18" id="password_validate">
                            <input type="password" class="form-control onpress_enter" id="passwordInput"  autocomplete="off" name="password" placeholder="{{ __('home.Password') }}" required>
                            <p class="error-inp" id="password_err_msg"></p>                            
                        </div>
                        <div class="form-floating-mb18" id="confirm_password_validate">
                            <input type="password" class="form-control onpress_enter" id="confirm_passwordInput"  autocomplete="off" name="confirm_password" placeholder="{{ __('home.ConfirmPassword') }}" required>
                            <p class="error-inp" id="confirm_password_err_msg"></p>                            
                        </div>
                        <div class="form-floating-mb18">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agreeAll" name="all">
                                    <label class="form-check-label" for="agreeAll"> 
                                        <span class="label-text"> 사용자 약관 전체 동의 </span>
                                    </label>
                                    <p class="error-inp" id="agreeAll_Error"></p>
                                    <p class="error-inp" id="server_err_msg"></p>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="form-floating-mb0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agreeService" name="service">
                                <label class="form-check-label" for="agreeService" > 
                                    <span class="label-text"> 서비스 이용 약관 동의 (필수) </span>
                                </label>
                                <div class="icon-container" data-url="{{ asset('/assets/html/service.html') }}">
                                        <i class="fas fa-chevron-down" ></i>
                                </div>
                            </div>
                            <div class="policy" id="policy-service" style="display: none;">
                            </div>
                        </div>
                        <div class="form-floating-mb0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agreePrivacy" name="privacy">
                                <label class="form-check-label" for="agreePrivacy"> 
                                    <span class="label-text"> 개인정보 처리방침 동의 (필수) </span>
                                </label>                                    
                                <div class="icon-container" data-url="{{ asset('/assets/html/privacy.html') }}">
                                        <i class="fas fa-chevron-down" ></i>
                                </div>
                            </div>
                            <div class="policy" id="policy-service" style="display: none;">
                            </div>                         
                        </div>
                        <div class="form-floating-mb0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agree14" name="y14">
                                <label class="form-check-label" for="agree14"> 
                                    <span class="label-text"> 만 14세 이상 확인 (필수) </span>
                                </label>                                    
                                <div class="icon-container" data-url="{{ asset('/assets/html/14.html') }}">
                                        <i class="fas fa-chevron-down" ></i>
                                </div>
                            </div>
                            <div class="policy" id="policy-14" style="display: none;">
                            </div>                            
                        </div>
                        <div class="form-floating-mb0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agreeForever" name="forever">
                                <label class="form-check-label" for="agreeForever"> 
                                    <span class="label-text"> 평생회원제 동의 (선택) </span>
                                </label>                                    
                                <div class="icon-container" data-url="{{ asset('/assets/html/forever.html') }}">
                                        <i class="fas fa-chevron-down" ></i>
                                </div>
                            </div>
                            <div class="policy" id="policy-forever" style="display: none;">
                            </div>                            
                        </div>
                        <div class="form-floating-mb0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="agreeMessage" name="message">
                                <label class="form-check-label" for="agreeMessage"> 
                                    <span class="label-text"> 쿠폰, 이벤트 등 혜택 알림 동의 (선택) </span>
                                </label>                                    
                                <div class="icon-container" data-url="{{ asset('/assets/html/message.html') }}">
                                        <i class="fas fa-chevron-down" ></i>
                                </div>
                            </div>
                            <div class="policy" id="policy-message" style="display: none;">
                            </div>                            
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <div class="divider"></div>
                        <div class="form-floating mt-5 mb-3">
                            <button type="button" class="btn bg-black w-100" id="signUp_submit">{{ __('home.SignUp') }}</button>
                        </div>
                        <p class="p3 text-center">{{ __('home.SNSSignup') }}</p>
                        <div class="lgn-wt-btns d-flex">
                            <a href="{{route('login-kakao')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/talk.svg')}}" alt="talk" class=""> Kakao</a>
                            <a href="{{route('login-naver')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/n.svg')}}" alt="N" class=""> Naver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot password -->
    <div class="modal fade forgotPassDialog" tabindex="-1" aria-labelledby="forgotPassDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads text-center">
                        <h4 style="font-family: Pretendard-medium">FIND  PASSWORD</h3>
                        <p class="p3">{{ __('home.ForgotPassword') }}</p>
                    </div>
                    <form action="javaScript:Void(0);" id="forgot_form" method="post">
                        <div class="form-floating-mb18 mt-10 mb-30" id="forgot_email_validate">
                            <input type="email" class="form-control onpress_enter_forgotp" id="forgot_email" placeholder="{{ __('home.Email') }}" value="" name="forgot_email">
                            <p class="error-inp" style="bottom: -35px" id="forgot_email_err_msg"></p>
                        </div>
                        <div class="form-floating-mb18 mt-5 mb-3">
                            <button type="button" class="btn bg-black w-100" id="forgot_submit">{{ __('home.SendEmailforReset') }}</button>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- close -->
    <!--Change password Modal -->
    <div class="modal fade changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3">{{ __('home.ChangePassword') }}</h3>
                        <p class="p2">{{ __('home.setYourNewPasswordWithEnter') }} {{ __('home.oldPassword') }}</p>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="change_password_form">
                        <div class="form-floating"  id="old_password_validate">
                            <input type="password" class="form-control onenter_submi change_password_submit_cls" id="old_password" placeholder="{{ __('home.Password') }}" name="old_password">
                            <label for="old_password">{{ __('home.oldPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="old_password" />
                            <p class="error-inp" id="old_password_err_msg"></p>
                        </div>
                        <div class="form-floating"  id="new_change_password_validate">
                            <input type="password" class="form-control change_password_submit_cls" id="new_change_password" placeholder="{{ __('home.Password') }}" name="new_change_password">
                            <label for="new_change_password">{{ __('home.newPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="new_change_password" />
                            <p class="error-inp" id="new_change_password_err_msg"></p>
                        </div>
                        <div class="form-floating"   id="confirm_change_passowrd_validate">
                            <input type="password" class="form-control change_password_submit_cls" id="confirm_change_passowrd" placeholder="{{ __('home.Password') }}" name="confirm_change_passowrd">
                            <label for="confirm_change_passowrd">{{ __('home.confirmPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="confirm_change_passowrd" />
                            <p class="error-inp" id="confirm_change_passowrd_err_msg"></p>
                            <p class="error-inp" id="change_passowrd_password_err_msg"></p>
                            <p class="error-inp" style="color:green;" id="change_passowrd_password_success_msg"></p>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <?php /*
                        <div class="row password-instruction">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/structure/check-circle-green.svg')}}" alt="Check" class="passInsIcon" />One lowercase character
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2 checked-ins">
                                    <img src="{{asset('/assets/images/structure/check-circle-green.svg')}}" alt="Check" class="passInsIcon" />One special character
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />One uppercase character
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />8 characters minimum
                                </p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <p class="p2 mb-2">
                                    <img src="{{asset('/assets/images/structure/check-circle-gray.svg')}}" alt="Check" class="passInsIcon" />Passwords match
                                </p>
                            </div>
                        </div>
                        */ ?>
                        <button type="button" class="btn w-100 mt-3 mb-2" id="change_password_submit">{{ __('home.Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>   
