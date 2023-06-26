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
                <form id="sc_form" method="post">
                  <div class="hotelManageform-Content">
                    <div class="grayBox-w">
                      <div class="hotemmanageFormInrcnt">
                        <h5 class="hd5 h5">System Configuration</h5>
                        <div class="row">

                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="value_for_validate">
                              <input type="text" class="form-control" id="value_for" placeholder="Value For"
                                name="value_for" value="{{ isset($row->value_for) ? $row->value_for : '' }}"
                                >
                              <label for="value_for">Value For<span class="required-star">*</span></label>
                              <p class="error-inp" id="value_for_err_msg"></p>
                            </div>
                          </div>

                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="value_validate">
                              <input type="text" class="form-control decimal" id="value" placeholder="Value"
                                name="value" value="{{ isset($row->value) ? $row->value : '' }}">
                              <label for="value">Value<span class="required-star">*</span></label>
                              <p class="error-inp" id="value_err_msg"></p>
                            </div>
                          </div>
                          @php
                          /* 
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating" id="value_type_validate">
                            <input type="text" class="form-control" id="value_type" placeholder="Hotel Name"
                                name="value_type" value="{{ isset($row->value_type) ? $row->value_type : '' }}" disabled>
                              <label for="value_type">Value Type<span class="required-star">*</span></label>
                              <p class="error-inp" id="value_type_err_msg"></p>
                            </div>
                          </div> 
                          */ 
                          @endphp
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">
                  <input type="hidden" value="{{ isset($row->type) ? $row->type : '' }}" name="type" id="type">
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
  @include('common_models')
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

      $(document).on('keyup', '#value_for', function() {
        $("#hm_server_err_msg").text('');
        field_required('value_for', 'value_for', "Value For is required");
      });

      $(document).on('keyup', '#value', function() {
        $('#hm_server_err_msg').text('');
        field_required('value', 'value', "Value is required");
      });

      $(document).on('click', '.form_submit', function() {
        $('#hm_server_err_msg').text('');
        $('#savetype').val($(this).attr('data-btntype'));
        submit();
      });


      function submit() {
        $("#hm_server_err_msg").text('');
        var token = true;

        if (!field_required('value_for', 'value_for', "Value For is required"))
          token = false;
        
        if (!field_required('value', 'value', "Value is required"))
          token = false;
        
        if (token) {
            $(".form_submit").prop("disabled", true);
            loading();
            $(".form_submit").prop("disabled", true);
              $.post("{{ route('system-configuration-update') }}", $("#sc_form").serialize(), function(data) {
                // console.log(data);
                if (data.nextpageurl != undefined && data.nextpageurl != '' && data.status ==1) {
                  window.location.href = data.nextpageurl;
                } else {
                  $("#hm_server_err_msg").text('Something went wrong please try again.');
                  $(".form_submit").prop("disabled", false);
                }
                unloading();
              });

        }
      }

    });
  </script>
@endsection
