@extends('frontend.layout.head')
@section('body-content')
  @include('hotel.header')
  <!-- include left bar here -->
  <div class="main-wrapper-gray">
    @if (auth()->user()->access == 'admin')
      @include('admin.leftbar')
    @else
      @include('hotel.leftbar')
    @endif
    <div class="content-box-right hotel-management-sec">
      @include('hotel.complete_percentage')
      <div class="container-fluid">
        <div class="hotel-management-row d-flex flex-wrap">
          @include('hotel.hotel_manage_stepbar')
          <div class="hotel-management-right-col">
            <div class="tab-content stepsContent">
              <div class="">
                <form id="hm_addressNAttractions_form" method="post">
                  <div class="hotelManageform-Content">
                    <div class="grayBox-w">
                      <div class="hotemmanageFormInrcnt">
                        <h5 class="hd5 h5">{{ __('home.HotelAddress') }}</h5>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating withIconInp" id="address_validate">
                              <img src="{{ asset('/assets/images/') }}/structure/location-on-gray.svg" alt=""
                                class="locationIcon">
                              <input type="text" class="form-control" id="address" placeholder="{{ __('home.address') }}"
                                name="address" value="{{ $hotel->formatted_address }}">
                              <label for="address">{{ __('home.address') }}<span class="required-star">*</span></label>
                              <p class="error-inp" id="address_err_msg"></p>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-floating" id="sido_validate">
                              <input type="text" class="form-control" id="sido" placeholder="{{ __('home.sido') }}" 
                              name="sido" value="{{ $hotel->sido }}">
                              <label for="sido">{{ __('home.City') }}<span class="required-star">*</span></label>
                              <p class="error-inp" id="sido_err_msg"></p>
                            </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-floating" id="sigungu_validate">
                              <input type="text" class="form-control" id="sigungu" placeholder="{{ __('home.sigun') }}" 
                              name="sigungu" value="{{ $hotel->sigungu }}">
                              <label for="sigungu">{{ __('home.sigun') }}<span class="required-star">*</span></label>
                              <p class="error-inp" id="sigungu_err_msg"></p>
                            </div>
                          </div>
                          <h5 class="hd5 h5">{{ __('home.phone') }}</h5>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                          <div class="form-floating mb-3" id="areacode_validate">
                                <button id="selectAreacode" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false">{{ (isset($hotel->areacode) && $hotel->areacode !='')?$hotel->areacode:'';  }}</button>
                                  <ul class="dropdown-menu dropdown-menu-start">
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="02" name="areacode" value="02" {{ (isset($hotel->areacode) && $hotel->areacode=='02' )?'checked':''; }} />
                                          <label for="02">02</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="031" name="areacode" value="031" {{ (isset($hotel->areacode) && $hotel->areacode=='031' )?'checked':''; }} />
                                          <label for="031">031</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="032" name="areacode" value="32" {{ (isset($hotel->areacode) && $hotel->areacode=='032' )?'checked':''; }} />
                                          <label for="032">032</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="033" name="areacode" value="033" {{ (isset($hotel->areacode) && $hotel->areacode=='033' )?'checked':''; }} />
                                          <label for="033">033</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="041" name="areacode" value="041" {{ (isset($hotel->areacode) && $hotel->areacode=='041' )?'checked':''; }} />
                                          <label for="041">041</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="042" name="areacode" value="042" {{ (isset($hotel->areacode) && $hotel->areacode=='042' )?'checked':''; }} />
                                          <label for="042">042</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="043" name="areacode" value="043" {{ (isset($hotel->areacode) && $hotel->areacode=='043' )?'checked':''; }} />
                                          <label for="043">043</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="051" name="areacode" value="051" {{ (isset($hotel->areacode) && $hotel->areacode=='051' )?'checked':''; }} />
                                          <label for="02">051</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="052" name="areacode" value="052" {{ (isset($hotel->areacode) && $hotel->areacode=='052' )?'checked':''; }} />
                                          <label for="052">052</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="053" name="areacode" value="053" {{ (isset($hotel->areacode) && $hotel->areacode=='053' )?'checked':''; }} />
                                          <label for="053">053</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="054" name="areacode" value="054" {{ (isset($hotel->areacode) && $hotel->areacode=='054' )?'checked':''; }} />
                                          <label for="054">054</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="055" name="areacode" value="055" {{ (isset($hotel->areacode) && $hotel->areacode=='055' )?'checked':''; }} />
                                          <label for="055">055</label>
                                      </li>                                      
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="061" name="areacode" value="061" {{ (isset($hotel->areacode) && $hotel->areacode=='061' )?'checked':''; }} />
                                          <label for="061">061</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="062" name="areacode" value="062" {{ (isset($hotel->areacode) && $hotel->areacode=='062' )?'checked':''; }} />
                                          <label for="062">062</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="063" name="areacode" value="063" {{ (isset($hotel->areacode) && $hotel->areacode=='063' )?'checked':''; }} />
                                          <label for="063">063</label>
                                      </li>
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="064" name="areacode" value="064" {{ (isset($hotel->areacode) && $hotel->areacode=='064' )?'checked':''; }} />
                                          <label for="064">064</label>
                                      </li>                                      
                                      <li class="radiobox-image">
                                          <input type="radio" class="select_areacode" id="070" name="areacode" value="070" {{ (isset($hotel->areacode) && $hotel->areacode=='070' )?'checked':''; }} />
                                          <label for="070">070</label>
                                      </li>
                                  </ul>
                                  <label for="areaCode" class="label {{ (isset($hotel->areacode) && $hotel->areacode !='')?'label_add_top':'';  }}">Area code<span class="required-star">*</span></label>
                                  <p class="error-inp" id="areacode_err_msg"></p>
                              </div>
                          </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                             <div class="form-floating" id="phone_validate">
                              <input type="text" class="form-control  phone_number_input rightClickDisabled"
                                id="phone" placeholder="{{ __('home.phone') }}" name="phone" value="{{ $hotel->phone }}">
                              <label for="phone">{{ __('home.phone') }}<span class="required-star">*</span></label>
                              <p class="error-inp" id="phone_err_msg"></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="grayBox-w">
                      <div class="d-flex align-items-center mb-4 textWtaddBtn flex-wrap">
                        <h5 class="h5">{{ __('home.nearByTouristAttractions') }}</h5>
                        <p class="p2 mb-0 addAttBtn ml-auto cursor-p addNewNTA"><img
                            src="{{ asset('/assets/images/') }}/structure/add-circle.svg" alt=""
                            class="add-circle"> {{ __('home.addAttraction') }}</p>
                      </div>
                      <div class="hotemmanageFormInrcnt" id="nta_list">
                        @foreach ($hotel->hasAttractions as $row)
                          <div class="attractionItemBox" id="attractionItemBoxdb_{{ $row->id }}">
                            <div class="row">
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="attraction_name_db_{{ $row->id }}"
                                    placeholder="{{ __('home.attractionName') }}" value="{{ $row->attractions_name }}"
                                    name="attraction_name[]">
                                  <label for="attraction_name_db_{{ $row->id }}">{{ __('home.attractionName') }}<span
                                      class="required-star">*</span></label>
                                </div>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control"
                                    id="attraction_adres_db_{{ $row->id }}" placeholder="{{ __('home.address') }}"
                                    name="attraction_adres[]" value="{{ $row->nta_address }}">
                                  <label for="attraction_adres_db_{{ $row->id }}">{{ __('home.address') }}<span
                                      class="required-star">*</span></label>
                                </div>
                              </div>
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-floating editorField">
                                  <textarea id="attraction_desc_db_{{ $row->id }}" placeholder="{{ __('home.description') }}" class="form-control"
                                    name="attraction_desc[]">{{ $row->nta_description }}</textarea>
                                  <p class="mb-0 max-char-limit">{{ __('home.max200haracters') }}</p>
                                </div>
                              </div>
                            </div>
                            <input type="hidden" name="nta_longitude[]" value="{{ $row->nta_longitude }}"
                              id="nta_longitude_db_{{ $row->id }}">
                            <input type="hidden" name="nta_latitude[]" value="{{ $row->nta_latitude }}"
                              id="nta_latitude_db_{{ $row->id }}">
                            <input type="hidden" name="rid[]" value="{{ $row->id }}">
                            <img src="{{ asset('/assets/images/') }}/structure/trash-red.svg" alt=""
                              class="trashIcon cursor-p delete_ntadb" data-i="{{ $row->id }}">
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="latitude" id="latitude" value="{{ $hotel->latitude }}">
                  <input type="hidden" name="longitude" id="longitude" value="{{ $hotel->longitude }}">
                  <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                  <input type="hidden" value="next" name="savetype" id="savetype">
                  <input type="hidden" value="{{ $hotel->hotel_id }}" name="h" id="h">
                  <div class="res-sub-btn-rw d-flex justify-content-end align-items-center pl-2">
                    <a href="{{ route('hm_basic_info', $hotel->hotel_id) }}" class="btn-back btnPrevious">{{ __('home.Back') }}</a>
                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}">Cancel</a>
                    <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit">{{ __('home.SaveExit') }}</button>
                    <button type="button" class="btn btnNext tab2 form_submit" data-btntype="next">{{ __('home.NextContinue') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->
@section('js-script')
  <script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
  <!-- <script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&amp;libraries=places&amp;language=ko&callback=gres">
  </script> -->
  <script>
    loadgoogle_map();
    // get hotel address 
    function loadgoogle_map(id = 'address') {
      var options = {
        language: 'ko'
      };
      var hotel_addr = new google.maps.places.Autocomplete(document.getElementById(id), options);
      hotel_addr.addListener('place_changed', function() {
        var place = hotel_addr.getPlace();
        var address = place.formatted_address;
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;

          // 주소 구성 요소 초기화
        var country = '';
        var administrativeLevel1 = '';
        var locality = '';
        
        for (var i = 0; i < place.address_components.length; i++) {
          var component = place.address_components[i];
          var componentType = component.types[0];

          switch (componentType) {
            case 'administrative_area_level_1':
              administrativeLevel1 = component.long_name;
            break;
            case 'locality':
              locality = component.long_name;
            break;
            case 'sublocality_level_1':
              locality = component.long_name;
            break;
            case 'country':
              country = component.long_name;
            break;
          }
        }

  // 주소 값 할당
//  address = [streetNo, route].filter(Boolean).join(' ');
        document.getElementById('address').value = address;
        document.getElementById('sido').value = administrativeLevel1;
        document.getElementById('sigungu').value = locality;
      });        

    }
    // get nearest tourist attractions location   
    function getNTALocation(id, nta_lat, nta_lang) {
      var options = {
        //componentRestrictions: {country: ["CY"]} //DE
        language: 'ko'
      };
      var places = new google.maps.places.Autocomplete(document.getElementById(id), options);
      google.maps.event.addListener(places, 'place_changed', function() {
        var place = places.getPlace();
        var address1 = place.formatted_address;
        var latitude1 = place.geometry.location.lat();
        var longitude1 = place.geometry.location.lng();
        document.getElementById(nta_lat).value = latitude1;
        document.getElementById(nta_lang).value = longitude1;
      });
    }
  </script>
  <script>
      function animateElements() {
        $('.progressbar').each(function() {
          var elementPos = $(this).offset().top;
          var topOfWindow = $(window).scrollTop();
          var percent = $(this).find('.circle').attr('data-percent');
          var animate = $(this).data('animate');
          if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
            $(this).data('animate', true);
            $(this).find('.circle').circleProgress({
              startAngle: -Math.PI / 2,
              value: percent / 100,
              size: 55,
              thickness: 5,
              fill: {
                color: '#015AC3'
              }
            }).on('circle-animation-progress', function(event, progress, stepValue) {
              $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
            }).stop();
          }
        });
      }
      animateElements();
      $(window).scroll(animateElements);
  </script>
  <script>
    $(document).ready(function() {
      $('#phone').mask('0000-0000');
      // form-validation and submit form  
      $(document).on('keyup', '#address', function() {
        $("#hm_server_err_msg").text('');
        if (field_required('address', 'address', "You need to search address"))
          if (!checkMaxLength($('#address').val(), 200))
            setErrorAndErrorBox('address', 'Set the address of the hotel');
          else
            unsetErrorAndErrorBox('address');
      });
      $(document).on('click','.select_areacode',function(){                
        if(!($('input:radio[name=areacode]:checked').val()))
            setErrorAndErrorBox('areacode','Please select any Area code form list.');
        else
            unsetErrorAndErrorBox('areacode');
      });
      $(document).on('keyup', '#phone', function() {
        if (field_required('phone', 'phone', "Phone number is required"))
          if (!checkMinLength($("#phone").val(), 8) || !checkMaxLength($("#phone").val(), 9))
            setErrorAndErrorBox('phone', 'Please enter a valid phone number.');
          else
            unsetErrorAndErrorBox('phone');
      });
      $(document).on('click', '.form_submit', function() {
        $('#hm_hm_server_err_msg').text('');
        $('#savetype').val($(this).attr('data-btntype'));
        form_submit();
      });
      function form_submit() {
        var token = true;
        if (!field_required('address', 'address', "You need to set the address of the hotel"))
          token = false;
       
        var areacode = $("input[name='areacode']:checked").val();
        if(areacode == undefined || areacode =='')
        {
            setErrorAndErrorBox('areacode','Please select any Area code form list.');
            token = false;
        }
        if (!field_required('phone', 'phone', "Phone number is required"))
          token = false;
        else if (!checkMinLength($("#phone").val(), 8) || !checkMaxLength($("#phone").val(), 9)) {
          setErrorAndErrorBox('phone', 'Please enter a valid phone number.');
          token = false;
        } else
          unsetErrorAndErrorBox('phone');

        if (token) {
          $(".form_submit").prop("disabled", true);
          loading();
          $.post("{{ route('hm_addressNAttractions_submit') }}", $("#hm_addressNAttractions_form").serialize(),
            function(data) {
              console.log(data);
              if (data.status == 1) {
                window.location.href = data.nextpageurl;
                unloading();
              } else {
                $(".form_submit").prop("disabled", false);
                $('#hm_hm_server_err_msg').text(data.message);
              }
              unloading();
            });
        }
      }
      // close
      // del NTA from db    
      $(document).on('click', '.delete_ntadb', function() {
        // delNTA
        var i = $(this).attr('data-i');
        $.post("{{ route('delNTA') }}", {
          _token: "{{ csrf_token() }}",
          h: "{{ $hotel->hotel_id }}",
          i: i
        }, function(data) {
          if (data.status == 1) {
            $("#attractionItemBoxdb_" + i).remove();
            $("#commonSuccessMsg").text(data.message);
            $("#commonSuccessBox").css('display', 'block');
            setTimeout(function() {
              $("#commonSuccessBox").hide();
            }, 3000);
            unloading();
          } else {
            unloading();
            $("#commonErrorMsg").text(data.message);
            $("#commonErrorBox").css('display', 'block');
            setTimeout(function() {
              $("#commonErrorBox").hide();
            }, 3000);
          }
        });
      });
      // del new NTA before db
      $(document).on('click', '.delete_nta', function() {
        var i = $(this).attr('data-i');
        $("#attractionItemBox_" + i).remove();
      });

      $(document).on('click', '.addNewNTA', function() {
        var alltexteditorcount = $('.attractionItemBox').length + 1;
        $('#nta_list').prepend('<div class="attractionItemBox inputbox-nta" id="attractionItemBox_' + alltexteditorcount +
        '"><div class="row"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"><div class="form-floating"><input type="text" class="form-control" id="attraction_name_2" placeholder="Attraction Name" value="" name="attraction_name[]"><label for="attraction_name_2">Attraction Name<span class="required-star">*</span></label></div></div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"><div class="form-floating"><input type="text" class="form-control" id="attraction_adres_' +
        alltexteditorcount +
        '" placeholder="Address" name="attraction_adres[]"><label for="attraction_adres_2">Address<span class="required-star">*</span></label></div></div><div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="form-floating editorField"><textarea id="attraction_desc_' +
        alltexteditorcount +
        '" placeholder="Description" class="form-control" name="attraction_desc[]" maxlength="200"></textarea><p class="mb-0 max-char-limit">max 200 characters</p></div></div></div><img src="{{ asset('/assets/images/') }}/structure/trash-red.svg" alt="" class="trashIcon cursor-p delete_nta" data-i="' +
        alltexteditorcount + '"><input type="hidden" name="nta_longitude[]" value="" id="nta_longitude_' +
        alltexteditorcount + '"><input type="hidden" name="nta_latitude[]" value="" id="nta_latitude_' +
        alltexteditorcount + '"><input type="hidden" name="rid[]" value="0"></div>');
    
        getNTALocation('attraction_adres_' + alltexteditorcount, 'nta_latitude_' + alltexteditorcount,'nta_longitude_' + alltexteditorcount);
      });
    });
  </script>
@endsection

