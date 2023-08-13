@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
<!-- include left bar here -->
<div class="main-wrapper-gray">
     @if(auth()->user()->access == 'admin')
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
                            <form id="hm_basic_info_form" method="post">
                                <div class="hotelManageform-Content">
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                        <h5 class="hd5 h5 mb-2">{{ __('home.HotelBasicInfo') }} </h5>
                                        <br></br>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="hotelInfoRow d-flex align-items-center">
                                                        <div class="uploadhotelimageBox">
                                                            <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon cursor-p"  id="picDelcross" style="display:{{($hotel->logo !='' )?'block':'none'; }}">
                                                            <img src="{{asset('/hotel_logo/'.$hotel->logo); }}" alt="" class="uploadhotelimage " id="myprofilepic" style="display:{{($hotel->logo !='' )?'block':'none'; }}">
                                                            <img src="{{asset('/assets/images/')}}/structure/hotel_default.png" alt="" class="uploadhotelimage" id="defaultprofilepic" style="display:{{($hotel->logo =='' )?'block':'none'; }}">
                                                            <input type="file" class="uploadinput image"  name="logo" id="logo" accept="image/png, image/jpeg">
                                                        </div>
                                                        <div class="hotelInfoDes">
                                                            <p class="p2 mb-2">{{ __('home.UploadLogo') }}<span class="required-star">*</span></p>
                                                            <p class="p4 mb-0">{{ __('home.UploadHotelLogoInstruction') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-floating" id="hotel_name_validate">
                                                        <input type="text" class="form-control" id="hotel_name" placeholder="{{ __('home.HotelName') }}" name="hotel_name" value="{{$hotel->hotel_name}}">
                                                        <label for="hotel_name">{{ __('home.HotelName') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="hotel_name_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <p class="p2 mb-2">{{ __('home.HotelDescription') }}</p>
                                                    <div class="form-floating editorField"  id="hotel_description_validate">
                                                        <textarea  placeholder="{{ __('home.HotelDescription') }}" name="hotel_description" id="hotel_description" value="{{$hotel->description}}">{{$hotel->description}}</textarea>
                                                        <p class="mb-0 max-char-limit" id="hotel_description_max_char"></p>
                                                        <p class="error-inp" id="hotel_description_err_msg"></p>
                                                        <p class="error-inp" id="hm_server_err_msg"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                    <h5 class="hd5 h5 mb-2">{{ __('home.UploadHotelImage') }}</h5>
                                    <br></br>
                                        <div class="hotelmanageFormInrcnt">
                                            <div class="uploadImageRow d-flex align-items-center">
                                                <input type="file" class="uploadinput otherimageinput" id="otherimageinput">
                                                <img src="{{asset('/assets/images/')}}/structure/upload-icon.svg" alt="" class="uploadIcon">
                                                <div class="uploadImageDes">
                                                    <p class="p2 mb-2">{{ __('home.UploadHotelImageInstruction') }}</p>
                                                </div>
                                            </div>
                                            <div class="hotelImagesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection">
                                                @foreach ($hotel->hasImage as $image)
                                                    <div class="hotelImgaesPreviewCol" id="hotel_img_{{$image->id}}">
                                                        <img src="{{ asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon delHotelOtherImg" data-i="{{$image->id}}">
                                                        <i class="markfeaturedhmimg {{ ($image->is_featured==1)?'fa fa-star favStar favStar-fill':'fa fa-star-o favStar favStar-outline'; }} " data-i="{{$image->id}}" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>대표 사진으로 설정되었습니다.</small> </div>" id="featured_icon_{{$image->id}}"></i>
                                                        <img src="{{ asset('/hotel_images/'.$image->image); }}" alt="N.A." class="img-thumbnail">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                <input type="hidden" value="next" name="savetype" id="savetype">
                                <input type="hidden" value="{{$hotel->hotel_id}}" name="h" id="h">
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.Cancel') }}</a>
                                    <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                    <button type="button" class="btn btnNext tab1 form_submit" data-btntype="next">{{ __('home.Next') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="modalLabel">Upload & Crop Hotel Logo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('home.Cancel') }}</button>
        <button type="button" class="btn btn-primary" id="crop">{{ __('home.Crop') }}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hotelOtherImgMdl" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="modalLabel">Upload & Crop Hotel Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="otherimage">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('home.Cancel') }}</button>
        <button type="button" class="btn btn-primary" id="cropother">{{ __('home.Crop') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- common models -->
@include('common_modal')

@include('frontend.layout.footer_script')
@endsection
<style type="text/css">
    #modal img {
    display: block;
    max-width: 100%;
    }
    .preview {
    overflow: hidden;
    width: 200px;
    height: 200px;
    margin: 60px;
    border: 4px solid #008B8B;
    }
    .modal-lg{
    max-width: 1000px !important;
    }
    #hotelOtherImgMdl img
    {
    display: block;
    max-width: 100%;
    }
</style>

<!-- JS section  -->
@section('js-script')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

<script type="text/javascript">
    CKEDITOR.replace( 'hotel_description', {
        allowedContent: false,
        removePlugins: 'save,print,preview,image,find,about,maximize,showblocks, sourcearea',
        removeButtons: 'Maximize, Code'
        });
</script>
<script>
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        var editor = CKEDITOR.instances.hotel_description;
        var maxCharacterCount = 1000;
        var content = editor.getData();
        var characterCount = getCharacterCount(content);

        $('#hotel_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자');

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

                    if (percent == 100) {
                    $(this).siblings('.prog-des').find('h6').text("{{ __('home.CompletedProfile') }}");
                    }
                }
            });
        }
        animateElements();
        $(window).scroll(animateElements);

    // form validation

        $(document).on('keyup','#hotel_name',function(){
            $("#hm_server_err_msg").text('');

            var maxNameCount = 50;
            var hotelName = $('#hotel_name').val();
            var NameCount = getCharacterCount(hotelName);

            if(field_required('hotel_name','hotel_name','숙박시설 이름은 필수 입력항목 입니다.'))

            if(NameCount > maxNameCount)
                setErrorAndErrorBox('hotel_name','숙박시설이름은 50자를 넘을 수 없습니다.');
             else
                unsetErrorAndErrorBox('hotel_name');
        });


        $(document).on('click','.form_submit',function(){
            $('#hm_hm_server_err_msg').text('');
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });


        editor.on('change', function() {
            $("#hm_server_err_msg").text('');
            content = editor.getData();
            characterCount = getCharacterCount(content);

            $('#hotel_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자');

            if(characterCount === 0) {
                setErrorAndErrorBox('hotel_description','숙박시설 설명은 필수 입력항목 입니다.');
            }
            else if(characterCount > 1000)
            {
                setErrorAndErrorBox('hotel_description','숙박시설 설명은 1000자를 넘을 수 없습니다.');
            }
            else
               unsetErrorAndErrorBox('hotel_description');
        });

        function getCharacterCount(content) {
            var normalizedText = content.normalize('NFC');
            var plainText = normalizedText.replace(/(<([^>]+)>)/gi, '');

            return plainText.length;
        }

        //form submit
        function form_submit()
        {
            var token=true;
            content = editor.getData();
            characterCount = getCharacterCount(content);
            hotelName = $('#hotel_name').val();
            NameCount = getCharacterCount(hotelName);

            $('#hotel_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자');

            if(!field_required('hotel_name','hotel_name','숙박시설이름은 필수 입력항목 입니다.'))
                token = false;
            else if(NameCount > 50 )
            {
                setErrorAndErrorBox('hotel_name','숙박시설이름은 50자를 넘을 수 없습니다.');
                token = false;
            }
            if(characterCount === 0) {
                setErrorAndErrorBox('hotel_description','숙박시설 설명은 필수 입력항목 입니다.');
                token = false;
            }
            else if(characterCount > 1000 )
            {
                setErrorAndErrorBox('hotel_description','숙박시설 설명은 1000자를 넘을 수 없습니다.');
                token = false;
            }
            if(token)
            {
                $(".form_submit").prop("disabled",true);
                loading();
                let senddata = {hotel_name:$('#hotel_name').val(),hotel_description:editor.getData(),h:$('#h').val(),_token:$('#tk').val(),savetype:$('#savetype').val()};
                $.post("{{ route('hm_basic_info_submit') }}",  senddata, function( data ) {
                    if(data.status==1){
                        window.location.href = data.nextpageurl;
                        unloading();
                    }
                    else
                    {
                        $(".form_submit").prop("disabled",false);
                        $('#hm_hm_server_err_msg').text(data.message);
                    }
                    unloading();
                });
            }
        }

        // Logo Image Control
        // Logo Image Upload
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".image", function(e){
            var files = e.target.files;
            var done = function (url) {
            image.src = url;
            $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            }
        });

        // logo cropping
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
        });
        $("#crop").click(function(){
            loading();
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('uploadHotelLogo') }}",
                        data: {'_token': "{{ csrf_token() }}", 'image': base64data,id:"{{ $hotel->hotel_id}}"},
                        success: function(data){
                            if(data.status==1)
                            {
                                // unloading();
                                // location.reload();
                                var picurl = "{{asset('/hotel_logo/'); }}";
                                picurl = picurl+'/'+data.logo;
                                $('#defaultprofilepic').css('display','none');
                                $('#picDelcross').css('display','block');
                                $('#myprofilepic').attr('src',picurl);
                                // document.getElementById("myprofilepic").src=picurl;
                                $('#myprofilepic').css('display','block');
                                //
                                $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000);
                                unloading();
                            }
                            else
                            {
                                unloading();
                                $("#commonErrorMsg").text(data.message);
                                $("#commonErrorBox").css('display','block');
                                setTimeout(function() {
                                    $("#commonErrorBox").hide();
                                }, 3000);
                            }
                            $modal.modal('hide');
                            // alert("success upload image");
                        }
                    });
                }
            });
        });

        // delete hotel logo
        $(document).on('click','#picDelcross',function(){
            $.post("{{ route('delHotelLogo') }}",{_token:"{{ csrf_token() }}",id:"{{ $hotel->hotel_id}}"}, function(data){
                if(data.status==1)
                {
                    $('#defaultprofilepic').css('display','block');
                    $('#picDelcross').css('display','none');
                    $('#myprofilepic').css('display','none');
                    $('#myprofilepic').attr('src',"{{asset('/hotel_logo/'.$hotel->logo); }}");
                    $("#commonSuccessMsg").text(data.message);
                    $("#commonSuccessBox").css('display','block');
                    setTimeout(function() {
                        $("#commonSuccessBox").hide();
                    }, 3000);
                    unloading();
                }
                else
                {
                    unloading();
                    $("#commonErrorMsg").text(data.message);
                    $("#commonErrorBox").css('display','block');
                    setTimeout(function() {
                        $("#commonErrorBox").hide();
                    }, 3000);
                }
            });
        });
    })
</script>

<!-- Hotel Image control  -->
<script>
    // Logo Image Upload
    var $modal = $('#hotelOtherImgMdl');
    var image = document.getElementById('otherimage');
    var cropper;
    $("body").on("change", ".otherimageinput", function(e) {
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
              // Check if the image is portrait
            image.addEventListener('load', function() {
                var width = image.width;
                var height = image.height;
                if (height > width) {
                    alert("세로 이미지는 업로드 하실 수 없습니다.");
                    return;
                }
                $modal.modal('show');
            });
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
        aspectRatio: 16 / 9,
        viewMode: 3,
        preview: '.preview'
        });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

    $("#cropother").click(function(){
        loading();
        canvas = cropper.getCroppedCanvas({
            width: 1600,
            height: 900,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('uploadHotelOtherImages') }}",
                    data: {'_token': "{{ csrf_token() }}", 'image': base64data,h:"{{ $hotel->hotel_id}}"},
                    success: function(data){
                        if(data.status==1) {
                                $('#otherimagessection').append(data.img);
                                $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 3000);
                        unloading();
                        }
                        else
                        {
                            unloading();
                            $("#commonErrorMsg").text(data.message);
                            $("#commonErrorBox").css('display','block');
                            setTimeout(function() {
                                $("#commonErrorBox").hide();
                            }, 3000);
                        }
                    $modal.modal('hide');
                    },
                    error: function(xhr, status, error) {
                    // Handle the error here
                    console.log("AJAX Error:", error);
                    }
                });
            }
        });
    });

    // delete hotel image
    $(document).on('click','.delHotelOtherImg',function(){
        var i = $(this).attr('data-i');
        $.post("{{ route('delHotelOtherImg') }}",{_token:"{{ csrf_token() }}",h:"{{ $hotel->hotel_id}}",i:i}, function(data){
            if(data.status==1)
            {
                $("#hotel_img_"+i).hide();
                $("#commonSuccessMsg").text(data.message);
                $("#commonSuccessBox").css('display','block');
                setTimeout(function() {
                    $("#commonSuccessBox").hide();
                }, 3000);
                unloading();
            }
            else
            {
                unloading();
                $("#commonErrorMsg").text(data.message);
                $("#commonErrorBox").css('display','block');
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 3000);
            }
        });
    });

    // mark featured hotel image
    $(document).on('click','.markfeaturedhmimg',function(){
        var i = $(this).attr('data-i');
        $.post("{{ route('markFeaturedHotelImg') }}",{_token:"{{ csrf_token() }}",h:"{{ $hotel->hotel_id}}",i:i}, function(data){
            if(data.status==1)
            {
                $('.markfeaturedhmimg').attr('class', 'markfeaturedhmimg fa fa-star-o favStar favStar-outline');
                $('#featured_icon_'+i).attr('class', 'markfeaturedhmimg fa fa-star favStar favStar-fill');
                // $(".markfeaturedhmimg").removeClass("fa-star");
                // $(".markfeaturedhmimg").removeClass("favStar-fill");
                // $(".markfeaturedhmimg").addClass("fa-star-o favStar-outline");
                // $(this).removeClass("fa-star-o favStar-outline")
                // $(this).addClass("fa-star favStar-fill");
                $("#commonSuccessMsg").text(data.message);
                $("#commonSuccessBox").css('display','block');
                setTimeout(function() {
                    $("#commonSuccessBox").hide();
                }, 3000);
                unloading();
            }
            else
            {
                unloading();
                $("#commonErrorMsg").text(data.message);
                $("#commonErrorBox").css('display','block');
                setTimeout(function() {
                    $("#commonErrorBox").hide();
                }, 3000);
            }
        });
    });
</script>
@endsection
