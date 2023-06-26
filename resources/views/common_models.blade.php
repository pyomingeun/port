    <!-- Login modeal -->
    <div class="modal fade loginDialog" tabindex="-1" aria-labelledby="loginDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3">{{ __('home.logIn') }}</h3>
                        <p class="p2">{{ __('ogInByEnteringYourAccountDetails') }}.</p>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="login_form">
                        <div class="form-floating" id="loginemail_validate">
                            <input type="email" class="form-control onpress_enter_login" id="loginemail" placeholder="name@example.com" value="" autocomplete="off" name="loginemail">
                            <label for="loginemail">{{ __('home.email') }}<span class="required-star">*</span></label>
                            <p class="error-inp" id="loginemail_err_msg"></p>
                        </div>
                        <div class="form-floating" id="loginpassword_validate">
                            <input type="password" class="form-control onpress_enter_login" id="loginpassword" placeholder="{{ __('home.password') }}"  autocomplete="off" name="loginpassword">
                            <label for="loginpassword">{{ __('home.password') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="loginpassword" />
                            <p class="error-inp" id="loginpassword_err_msg"></p>
                            <p class="error-inp" id="login_server_err_msg"></p>
                        </div>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <input type="hidden" value="{{ url()->full(); }}" name="nexturl" id="nexturl">
                        <div class="form-floating">
                            <button type="button" class="btn w-100" id="login_submit">{{ __('home.logIn') }}</button>
                        </div>
                        <p class="forgotPass-link text-center"><a href="#" data-bs-toggle="modal" data-bs-target=".forgotPassDialog" data-bs-dismiss="modal">{{ __('home.forgotPassword') }}?</a></p>
                        <div class="or d-flex align-items-center justify-content-center"><span>Or</span></div>
                        <div class="lgn-wt-btns d-flex">
                            <a href="{{route('login-kakao')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/talk.svg')}}" alt="talk" class=""> Kakao</a>
                            <a href="{{route('login-naver')}}" class="btn outline-gray w-50"><img src="{{asset('/assets/images/structure/n.svg')}}" alt="N" class=""> Naver</a>
                        </div>
                        <p class="p2 haveAccout text-center mt-4">{{ __('home.dontHaveAnAccount') }}? <a href="{{ route('signup') }}">{{ __('home.register') }}</a></p>
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
                    <div class="modal-heads">
                        <h3 class="h3">{{ __('home.forgotPassword') }}</h3>
                        <p class="p2">{{ __('home.Enteryouremailaddressandwewillseyoualinktoresetyoupassword') }}</p>
                    </div>
                    <form action="javaScript:Void(0);" id="forgot_form" method="post">
                        <div class="form-floating" id="forgot_email_validate">
                            <input type="email" class="form-control onpress_enter_forgotp" id="forgot_email" placeholder="name@example.com" value="" name="forgot_email">
                            <label for="forgot_email">{{ __('home.email') }}<span class="required-star">*</span></label>
                            <p class="error-inp" id="forgot_email_err_msg"></p>
                            <p class="error-inp" id="forgot_server_err_msg"></p>
                        </div>
                        <div class="form-floating d-flex align-items-center">
                            <a type="button" class="btn" id="forgot_submit">{{ __('home.send') }}</a>
                            <p class="p2 haveAccout text-center mt-0 mb-0 ml-auto">{{ __('home.backTo') }} <a href="#" data-bs-toggle="modal" data-bs-target=".loginDialog" data-bs-dismiss="modal">Log In</a></p>
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
                        <h3 class="h3">{{ __('home.changePassword') }}</h3>
                        <p class="p2">{{ __('home.setYourNewPasswordWithEnter') }} {{ __('home.oldPassword') }}</p>
                    </div>
                    <form action="javaScript:Void(0);" method="post" id="change_password_form">
                        <div class="form-floating"  id="old_password_validate">
                            <input type="password" class="form-control onenter_submi change_password_submit_cls" id="old_password" placeholder="{{ __('home.password') }}" name="old_password">
                            <label for="old_password">{{ __('home.oldPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="old_password" />
                            <p class="error-inp" id="old_password_err_msg"></p>
                        </div>
                        <div class="form-floating"  id="new_change_password_validate">
                            <input type="password" class="form-control change_password_submit_cls" id="new_change_password" placeholder="{{ __('home.password') }}" name="new_change_password">
                            <label for="new_change_password">{{ __('home.newPassword') }}<span class="required-star">*</span></label>
                            <img src="{{asset('/assets/images/structure/eye-icon-hide.svg')}}" alt="eye-icon" class="eye-icon eye" eye-for="new_change_password" />
                            <p class="error-inp" id="new_change_password_err_msg"></p>
                        </div>
                        <div class="form-floating"   id="confirm_change_passowrd_validate">
                            <input type="password" class="form-control change_password_submit_cls" id="confirm_change_passowrd" placeholder="{{ __('home.password') }}" name="confirm_change_passowrd">
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
