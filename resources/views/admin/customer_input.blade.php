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
                <form id="customer_input" method="post">
                  <div class="hotelManageform-Content">
                    <div class="grayBox-w">
                      <div class="hotelmanageFormInrcnt">
                        <h5 class="hd5 h5">Customer Info</h5>
                        <div class="row">

                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="email_validate">
                              <input type="text" class="form-control" id="email" placeholder="Hotel Email"
                                name="email" value="{{ isset($user->email) ? $user->email : '' }}"
                                {{ isset($user->email) ? 'disabled' : '' }}>
                              <label for="email">Email<span class="required-star">*</span></label>
                              <p class="error-inp" id="email_err_msg"></p>
                            </div>
                          </div>

                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="full_name_validate">
                              <input type="text" class="form-control" id="full_name" placeholder="Hotel Name"
                                name="full_name" value="{{ isset($user->full_name) ? $user->full_name : '' }}">
                              <label for="full_name">Full Name<span class="required-star">*</span></label>
                              <p class="error-inp" id="full_name_err_msg"></p>
                            </div>
                          </div>

                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="phone_validate">
                              <input type="text" class="form-control phone_number_input rightClickDisabled"
                                id="phone" placeholder="Phone" name="phone"
                                value="{{ isset($user->phone) ? $user->phone : '' }}">
                              <label for="phone">Phone<span class="required-star">*</span></label>
                              <p class="error-inp" id="phone_err_msg"></p>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">
                  <input type="hidden" value="{{ isset($user->id) ? $user->id : 0 }}" name="id" id="id">
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
    $(document).ready(function() {

      $('#phone').mask('000-0000-0000');
      // login 
      $(document).on('keyup', '.onpress_enter_submit', function(e) {
        // console.log(e.keyCode);
        if (e.keyCode == 13)
          submit();
      });

      $(document).on('keyup', '#email', function() {
        $("#hm_server_err_msg").text('');
        if (field_required('email', 'email', "Email is required"))
          if (!isEmail($('#email').val()))
            setErrorAndErrorBox('email', 'Please enter a valid email.');
          else {
            unsetErrorAndErrorBox('email');
            // checkEmailIsExist($('#email').val());
          }
      });

      $(document).on('keyup', '#full_name', function() {
        $('#hm_server_err_msg').text('');
        field_required('full_name', 'full_name', "Full name is required");
      });

      $(document).on('click', '.form_submit', function() {
        $('#hm_server_err_msg').text('');
        $('#savetype').val($(this).attr('data-btntype'));
        submit();
      });

      $(document).on('keyup', '#phone', function() {
        $("#server_err_msg").text('');
        if (field_required('phone', 'phone', "Phone is required"))
          if (!checkExactLength($("#phone").val(), 13))
            setErrorAndErrorBox('phone', 'Please enter a valid phone number.');
          else
            unsetErrorAndErrorBox('phone');

      });

      function submit() {
        $("#hm_server_err_msg").text('');
        var token = true;

        if (!field_required('email', 'email', "Email is required"))
          token = false;
        else if (!isEmail($('#email').val())) {
          setErrorAndErrorBox('email', 'Please enter a valid email.');
          token = false;
        }

        if (!field_required('full_name', 'full_name', "Full name is required"))
          token = false;
        else if (!checkMaxLength($('#full_name').val(), 200)) {
          setErrorAndErrorBox('full_name', 'Full name should be less than 200 letters.');
          token = false;
        }

        if (!field_required('phone', 'phone', "Phone number is required"))
          token = false;
        else if (!checkExactLength($("#phone").val(), 13)) {
          setErrorAndErrorBox('phone', 'Please enter a valid phone number.');
          token = false;
        } else
          unsetErrorAndErrorBox('phone');

        if (token) {
          $(".form_submit").prop("disabled", true);
          loading();
          var email = $('#email').val();
          var id = $('#id').val();
          if (id == 0) {
            $.post("{{ route('reg_emailcheck') }}", {
              email: email
            }, function(data) {
              if (data.status == 1) {
                $(".form_submit").prop("disabled", true);
                $.post("{{ route('customer_input_submit') }}", $("#customer_input").serialize(), function(data) {
                  // console.log(data);
                  if (data.nextpageurl != undefined && data.nextpageurl != '') {
                    window.location.href = data.nextpageurl;
                  } else {
                    $("#hm_server_err_msg").text('Something went wrong please try again.');
                    $(".form_submit").prop("disabled", false);
                  }
                  unloading();
                });
              } else {
                setErrorAndErrorBox('email', data.message);
                $(".form_submit").prop("disabled", false);
                unloading();
              }

            });
          } else {
            $(".form_submit").prop("disabled", true);
            $.post("{{ route('customer_input_submit') }}", $("#customer_input").serialize(), function(data) {
              // console.log(data);
              if (data.nextpageurl != undefined && data.nextpageurl != '') {
                window.location.href = data.nextpageurl;
              } else {
                $("#hm_server_err_msg").text('Something went wrong please try again.');
                $(".form_submit").prop("disabled", false);
              }
              unloading();
            });
          }

        }
      }
      // login close 

    });
  </script>
@endsection
