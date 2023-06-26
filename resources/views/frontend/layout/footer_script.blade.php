    <img src="{{ asset('/assets/images/structure/loading.gif') }}" id="loading_img">
    <script src="//cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js "></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js "></script>
    <script src="{{ asset('/assets/js/designer.js') }}"></script>
    <script src="{{ asset('/assets/js/designer-dropdown.js') }}"></script>
    <script src="{{ asset('/assets/js/script.js') }}"></script>
    <script src="{{ asset('/assets/js/input-mask.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        // console.log('kk-common');
        var flash_success_msg = "{{ Session::get('success_msg') }}";
        var flash_error_msg = "{{ Session::get('error_msg') }}";
        if (flash_success_msg != '') {
          // console.log('if');
          $("#commonSuccessMsg").text(flash_success_msg);
          $("#commonSuccessBox").css('display', 'block');
          setTimeout(function() {
            $("#commonSuccessBox").hide();
          }, 3000);
        }
        // else{ console.log('else'); }
        if (flash_error_msg != '') {
          $("#commonErrorMsg").text(flash_error_msg);
          $("#commonErrorBox").css('display', 'block');
          setTimeout(function() {
            $("#commonErrorBox").hide();
          }, 3000);
        }
        // Eye show/hide
        $(document).on('click', '.eye', function() {
          console.log('.eye');
          var input = $(this).attr('eye-for');
          console.log('kk-common');
          // $('#password').attr('value') == ''
          if ($('#' + input).attr("type") === "password") {
            $('#' + input).attr("type", "text");
            $(this).attr('src', "{{ asset('/assets/images/structure/eye-icon.svg') }}");
            // $(this).attr('eye-for');
          } else {
            $('#' + input).attr("type", "password");
            $(this).attr('src', "{{ asset('/assets/images/structure/eye-icon-hide.svg') }}");
          }
        });
        //_________________________________________________
        // login 
        $(document).on('keyup', '.onpress_enter_login', function(e) {
          if (e.keyCode == 13)
            login_submit();
        });
        $(document).on('keyup', '.onpress_enter_forgotp', function(e) {
          if (e.keyCode == 13)
            forgot_submit();
        });
        $(document).on('keyup', '#loginemail', function() {
          $('#login_server_err_msg').text('');
          if (field_required('loginemail', 'loginemail', "Email is required"))
            if (!isEmail($('#loginemail').val()))
              setErrorAndErrorBox('loginemail',
                'Please enter a valid email.'); // $("#loginemail_err_msg").text('Please enter a valid email.');
            else
              unsetErrorAndErrorBox('loginemail'); // $("#loginemail_err_msg").text('');
        });
        $(document).on('keyup', '#loginpassword', function() {
          $('#login_server_err_msg').text('');
          field_required('loginpassword', 'loginpassword', "Password is required");
        });
        $(document).on('click', '#login_submit', function() {
          $('#login_server_err_msg').text('');
          // var currentUrl = window.location.href;
          // $("#nexturl").val(currentUrl); 
          login_submit();
        });
        function login_submit() {
          var token = true;
          $('.error-inp').text('');
          if (!field_required('loginemail', 'loginemail', "Email is required"))
            token = false;
          else if (!isEmail($('#loginemail').val())) {
            setErrorAndErrorBox('loginemail', 'Please enter a valid email.');
            token = false;
          }
          if (!field_required('loginpassword', 'loginpassword', "Password is required"))
            token = false;
          if (token) {
            $("#login_submit").prop("disabled", true);
            loading();
            $.post("{{ route('login') }}", $("#login_form").serialize(), function(data) {
              console.log(data);
              if (data) {
                if (data.nextpageurl != '') {
                  // alert(data.nextpageurl);
                  window.location.href = data.nextpageurl;
                } else {
                  $('#login_server_err_msg').text(data.message);
                  $("#login_submit").prop("disabled", false);
                }
              }
              unloading();
            });
          }
        }
        // login close 
        // forgot password 
        $(document).on('keyup', '#forgot_email', function() {
          field_required('forgot_email', 'forgot_email', "Email is required");
          $('#forgot_server_err_msg').text('');
          if (field_required('forgot_email', 'forgot_email', "Email is required"))
            if (!isEmail($('#forgot_email').val()))
              setErrorAndErrorBox('forgot_email', 'Please enter a valid email.');
            else
              unsetErrorAndErrorBox('forgot_email');
        });
        $(document).on('click', '#forgot_submit', function() {
          $('#forgot_server_err_msg').text('');
          forgot_submit();
        });
        function forgot_submit() {
          var token = true;
          if (!field_required('forgot_email', 'forgot_email', "Email is required"))
            token = false;
          else if (!isEmail($('#forgot_email').val())) {
            setErrorAndErrorBox('forgot_email', 'Please enter a valid email.');
            token = false;
          }
          if (token) {
            $("#forgot_submit").prop("disabled", true);
            loading();
            $.post("{{ route('forgot_password') }}", $("#forgot_form").serialize(), function(data) {
              console.log(data);
              if (data.status == 1) {
                window.location.href = data.nextpageurl;
                unloading();
              } else {
                $("#forgot_submit").prop("disabled", false);
                $('#forgot_server_err_msg').text(data.message);
              }
              unloading();
            });
          }
        }
        // close forgot password 
        // change password 
        $(document).on('keyup', '.change_password_submit_cls', function(e) {
          if (e.keyCode == 13)
            changePasswordSubmit();
        });
        $(document).on('click', '#change_password_submit', function() {
          $('#change_passowrd_password_err_msg').text('');
          $('#change_passowrd_password_success_msg').text('');
          changePasswordSubmit();
        });
        $(document).on('keyup', '#old_password', function() {
          $('#change_passowrd_password_err_msg').text('');
          $('#change_passowrd_password_success_msg').text('');
          field_required('old_password', 'old_password', "New Password is required");
        });
        $(document).on('keyup', '#new_change_password', function() {
          $("#change_passowrd_password_err_msg").text('');
          $('#change_passowrd_password_success_msg').text('');
          if (field_required('new_change_password', 'new_change_password', "Password is required")) {
            if (!checkMinLength($('#new_change_password').val(), 8))
              setErrorAndErrorBox('new_change_password', 'New Password should be minimum 8 letters.');
            else {
              if (checkIsEqual($('#old_password').val(), $('#new_change_password').val()))
                setErrorAndErrorBox('confirm_change_passowrd', 'New Password and old password should be diffrent.');
              else
                unsetErrorAndErrorBox('new_change_password');
            }
          }
        });
        $(document).on('keyup', '#confirm_change_passowrd', function() {
          $("#change_passowrd_password_err_msg").text('');
          $('#change_passowrd_password_success_msg').text('');
          if (field_required('new_change_password', 'confirm_change_passowrd', "Confirm password is required")) {
            if (!checkIsEqual($('#new_change_password').val(), $('#confirm_change_passowrd').val()))
              setErrorAndErrorBox('confirm_change_passowrd', 'New Password and confirm password should be same.');
            else
              unsetErrorAndErrorBox('confirm_change_passowrd');
          }
        });
        function changePasswordSubmit() {
          $('#change_passowrd_password_success_msg').text('');
          var token = true;
          if (!field_required('old_password', 'old_password', "Password is required"))
            token = false;
          if (!field_required('new_change_password', 'new_change_password', "Password is required"))
            token = false;
          else if (!checkMinLength($('#new_change_password').val(), 8)) {
            setErrorAndErrorBox('new_change_password', 'Password should be minimum 8 letters.');
            token = false;
          } else if (checkIsEqual($('#old_password').val(), $('#new_change_password').val())) {
            setErrorAndErrorBox('new_change_password', 'Password and old password should be diffrent.');
            token = false;
          }
          if (!field_required('confirm_change_passowrd', 'confirm_change_passowrd', "Confirm password is required"))
            token = false;
          else if (!checkIsEqual($('#new_change_password').val(), $('#confirm_change_passowrd').val())) {
            setErrorAndErrorBox('confirm_change_passowrd', 'Password and confirm password should be same.');
            token = false;
          }
          if (token) {
            $("#change_password_submit").prop("disabled", true);
            loading();
            $.post("{{ route('change_password') }}", $("#change_password_form").serialize(), function(data) {
              // console.log(data);
              if (data.status == 1) {
                // window.location.href = data.nextpageurl;
                $("#change_password_form")[0].reset();
                $('#change_passowrd_password_err_msg').text('');
                // $('#change_passowrd_password_success_msg').text(data.message);
                $(".changePassword").modal('hide');
                $("#commonSuccessMsg").text(data.message);
                $("#commonSuccessBox").css('display', 'block');
                setTimeout(function() {
                  $("#commonSuccessBox").hide();
                }, 3000);
                unloading();
              } else {
                $('#change_passowrd_password_success_msg').text('');
                $('#change_passowrd_password_err_msg').text(data.message);
              }
              $("#change_password_submit").prop("disabled", false);
              unloading();
            });
          }
        }
        // close chagne password
        function checkEmailIsExist(email) {
          $.post("{{ route('reg_emailcheck') }}", {
            email: email
          }, function(data) {
            if (data.status == 0) {
              setErrorAndErrorBox('email', data.message);
              return false;
            } else
              return true;
          });
        }

        // news-letter section
        $(document).on('keyup', '#subscribe_email', function(e) {
            if (e.keyCode == 13)
              subsribe_submit();
        });

        $(document).on('click', '#subscribe_submit', function() {
          subsribe_submit();
        });
        // _____________________

        $(document).on('keyup', '#subscribe_email', function() {
          // field_required('subscribe_email', 'subscribe_email', "Email is required");
          $('#subscribe_server_err_msg').text('');
          $('#subscribe_server_success_msg').text('');
          
          if (field_required('subscribe_email', 'subscribe_email', "Email is required"))
            if (!isEmail($('#subscribe_email').val()))
              setErrorAndErrorBox('subscribe_email', 'Please enter a valid email.');
            else
              unsetErrorAndErrorBox('subscribe_email');
        });
        
        function subsribe_submit() {
          $('#subscribe_server_err_msg').text('');
          $('#subscribe_server_success_msg').text('');
          var token = true;
          if (!field_required('subscribe_email', 'subscribe_email', "Email is required"))
            token = false;
          else if (!isEmail($('#subscribe_email').val())) {
            setErrorAndErrorBox('subscribe_email', 'Please enter a valid email.');
            token = false;
          }
          if (token) {
            $("#subscribe_submit").prop("disabled", true);
            loading();
            $.post("{{ route('newsletter-subscribe') }}", $("#subscribe_form").serialize(), function(data) {
              console.log(data);
              if (data.status == 1) {
               // window.location.href = data.nextpageurl;
               $('#subscribe_server_success_msg').text(data.message);
               $('#subscribe_email').val('');
                unloading();
              } else {
                $("#subscribe_submit").prop("disabled", false);
                $('#subscribe_server_err_msg').text(data.message);
              }
              unloading();
              setTimeout(function() {
                  $('#subscribe_server_err_msg').text('');
                  $('#subscribe_server_success_msg').text('');
              }, 3000);
            });
          }
        }
        
      });
    </script>
