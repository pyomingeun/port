@extends('frontend.layout.head')
@section('body-content')
@include('hotel.header')
<div class="main-wrapper-gray">
    @if(auth()->user()->access == 'admin')
        @include('admin.leftbar')        
    @else
        @include('hotel.leftbar')
    @endif
    <div class="content-box-right hotel-management-sec add-room-sec">
        <div class="container-fluid">
            <div class="hotel-management-row d-flex flex-wrap">
                <!-- Room stepbar open -->
                @include('hotel.room_stepbar')
                <!-- room stepbar close -->
                <div class="hotel-management-right-col">
                    <div class="tab-content stepsContent">
                        <div>
                            <form  action="javaScript:Void(0);" method="post" id="room_basicinfo_form">
                                <div class="roomsManageform-Content RoomInfoBox">
                                    <div class="grayBox-w">
                                        <div class="hotelmanageFormInrcnt">
                                            <h5 class="hd5 h5">{{ __('home.RoomInfo') }}</h5>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-floating" id="room_name_validate">
                                                        <input type="text" class="form-control" id="room_name"  name="room_name" value="{{ isset($room->room_name)?$room->room_name:''; }}">
                                                        <label for="room_name">{{ __('home.RoomName') }}<span class="required-star">*</span></label>
                                                        <p class="error-inp" id="room_name_err_msg"></p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="inpWtTextRtbg d-flex">
                                                        <div class="form-floating" id="room_size_validate">
                                                            <input type="text" class="form-control only_integer rightClickDisabled" id="room_size"  name="room_size" value="{{ isset($room->room_size)?$room->room_size:''; }}" >
                                                            <label for="room_size">{{ __('home.RoomSize') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="room_size_err_msg"></p>
                                                        </div>
                                                        <span class="inpTextRtbg d-flex">m<sup>2</sup></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="p2 mb-0">{{ __('home.NoOfBathRoom') }}</span></p>
                                                        <div class="quantity-row">
                                                            <div class="quantity-box d-flex align-items-center ml-auto">
                                                                <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                <input type="text" class="form-control only_integer rightClickDisabled"  id="no_of_bathrooms"  name="no_of_bathrooms" value="{{ isset($room->no_of_bathrooms)?$room->no_of_bathrooms:'0'; }}" />
                                                                <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                                            </div>
                                            <div class="d-flex align-items-center mt-3">
                                                <p class="p2 mb-0">{{ __('home.Bed') }}</p>
                                                <p class="p2 mb-0 addAttBtn ml-auto cursor-p addBedBtn addNewBed"><img src="{{asset('/assets/images/')}}/structure/add-circle.svg" alt="" class="add-circle"> {{ __('home.AddBed') }}</p>
                                                </div>
                                                <div class="d-hide mt-4" id="beds_list">
                                                    @if(isset($room->hasBeds) && count($room->hasBeds) >0)
                                                        @foreach ($room->hasBeds as $bed)
                                                        <div class="row mb-4" id="beddb_{{ $bed->id}}">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                                <div class="form-floating mb-0">
                                                                    <input type="text" class="form-control" autocomplete="off"  placeholder="Bed Type" value="{{ $bed->bed_type}}" name="bed_type[]" id="bed_type_db_{{ $bed->id }}">
                                                                    <label for="bed_type_db_{{ $bed->id }}">{{ __('home.BedType') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 d-flex align-items-center justify-content-center">
                                                                <div class="quantity-row d-flex align-items-center">
                                                                    <div class="quantity-box d-flex align-items-center ml-auto">
                                                                       <span class="minus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                        <input type="text" value="{{ $bed->bed_qty}}" name="bed_qty[]" />
                                                                        <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset('/assets/images/')}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-end">
                                                                <img src="{{asset('/assets/images/')}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delbeddb" data-i="{{ $bed->id}}">
                                                            </div>
                                                            <input type="hidden" name="rid[]" value="{{$bed->id}}">
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h5 class="hd5 h5">{{ __('home.RoomDescription') }}</h5>
                                            <div class="form-floating editorField" id="room_description_validate">
                                                <textarea  placeholder="{{ __('home.roomDescription') }}" id="room_description"  name="room_description" value="{{ isset($room->room_description)?$room->room_description:''; }}" >{{ isset($room->room_description)?$room->room_description:''; }}</textarea>
                                                    <p class="mb-0 max-char-limit" id="room_description_max_char"></p>
                                                    <p class="error-inp" id="room_description_err_msg"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grayBox-w">
                                        <h5 class="hd5 h5 mb-2">{{ __('home.UploadHotelImage') }}</h5>
                                        <br></br>
                                        <div class="hotelmanageFormInrcnt RoomImagesBox">
                                            <div class="uploadImageRow d-flex align-items-center">
                                                <input type="file" class="uploadinput otherimageinput" id="otherimageinput" >
                                                <img src="{{asset('/assets/images/')}}/structure/upload-icon.svg" alt="" class="uploadIcon">
                                                <div class="uploadImageDes">
                                                    <p class="p2 mb-2">{{ __('home.UploadRoomImageInstruction') }}</p>
                                                </div>
                                            </div>
                                            <div class="hotelImagesPreviewRow d-flex flex-wrap mt-4" id="otherimagessection">
                                                @if(isset($room->hasImages) && count($room->hasImages) >0)
                                                @foreach ($room->hasImages as $image)
                                                <div class="hotelImgaesPreviewCol" id="room_img_{{$image->id}}">
                                                    <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon delRoomOtherImg"  data-i="{{$image->id}}">
                                                    <i class="markfeaturedhmimg {{ ($image->is_featured==1)?'fa fa-star favStar favStar-fill':'fa fa-star-o favStar favStar-outline'; }} " data-i="{{$image->id}}" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>대표 사진으로 설정되었습니다.</small> </div>" id="featured_icon_{{$image->id}}"></i>
                                                    <img src="{{ asset('/room_images/'.$image->room_image); }}"  alt="N.A." class="img-thumbnail">
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="res-sub-btn-rw d-flex justify-content-end">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tk">
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <input type="hidden" value="{{$slug}}" name="slug" id="slug">
                                    <a class="btn bg-gray1" href="{{ route('rooms') }}">{{ __('home.Cancel') }}</a>
                                    <button class="btn outline-blue form_submit" type="button" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                    <a class="btn btnNext tab1 form_submit" type="button" data-btntype="next">{{ __('home.Next') }}</a>
                                </div>
                            </form>
                        </div>                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="roomOtherImgMdl" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="modalLabel">Laravel Crop Image Before Upload using Cropper JS - NiceSnippets.com</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="otherimage" >
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('home.cancel') }}</button>
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
    #roomOtherImgMdl img
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
    CKEDITOR.replace( 'room_description', {
    allowedContent: false,
    removePlugins: 'save,print,preview,image,find,about,maximize,showblocks, sourcearea',
    removeButtons: 'Maximize, Code'
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    $(document).ready(function(){
        // form-validation and submit form  
        var maxNameCount = 20;
        var roomName = $('#room_name').val();
        var NameCount = getCharacterCount(roomName);

        var editor = CKEDITOR.instances.room_description;
        var maxCharacterCount = 500;
        var content = editor.getData();
        var characterCount = getCharacterCount(content);

        var bedCounter =1;

        $('#room_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자'); 

        $(document).on('click','.form_submit',function(){
            $('#hm_hm_server_err_msg').text('');
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });

        editor.on('change', function() { 
            $("#hm_server_err_msg").text('');
            content = editor.getData(); 
            characterCount = getCharacterCount(content);

            $('#room_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자'); 

            if(characterCount === 0) {
                setErrorAndErrorBox('room_description','객실 설명은 필수 입력항목 입니다.');
            }
            else if(characterCount > 500) 
            {
                setErrorAndErrorBox('room_description','객실 설명은 500자를 넘을 수 없습니다.');
            }
            else
               unsetErrorAndErrorBox('room_description');
        });

        $(document).on('click','.addNewBed',function(){
            $('#beds_list').prepend('<div class="row mb-4" id="bednew_'+bedCounter+'"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"><div class="form-floating mb-0"><input type="text" class="form-control" autocomplete="off" placeholder="Bed Type" value="" name="bed_type[]" id="bed_type_db_'+bedCounter+'"><label for="bed_type_db_'+bedCounter+'">{{ __('home.BedType') }}</label></div></div><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 d-flex align-items-center justify-content-center"><div class="quantity-row d-flex align-items-center"><div class="quantity-box d-flex align-items-center ml-auto"><span class="minus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/minus-icon.svg" class="plus-minus-icon" alt=""></span><input type="text" value="1" name="bed_qty[]" /> <span class="plus d-flex align-items-center justify-content-center"><img src="{{asset("/assets/images/")}}/structure/plus-icon.svg" class="plus-minus-icon" alt=""></span></div></div></div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 d-flex align-items-center justify-content-end"><img src="{{asset("/assets/images/")}}/structure/trash-red.svg" alt="" class="rmoveExtraSerIcon cursor-p ml-auto delbed" data-i="'+bedCounter+'"></div><input type="hidden" name="rid[]" value="0"></div>')});
        // Remove bed new box
        $(document).on('click','.delbed',function(){
            // console.log('delete_nta');
            var i = $(this).attr('data-i');
            // console.log(i);    
            $("#bednew_"+i).remove();            
        }); 
        // del bed from db    
        $(document).on('click','.delbeddb',function(){
            // delNTA
            var i = $(this).attr('data-i');
            $("#beddb_"+i).remove();
            $.post("{{ route('delBed') }}",{_token:"{{ csrf_token() }}",r:"{{ (isset($room->id))?$room->id:0 }}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#beddb_"+i).remove();    
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

        function getCharacterCount(content) {
            var normalizedText = content.normalize('NFC');
            var plainText = normalizedText.replace(/(<([^>]+)>)/gi, '');
  
            return plainText.length;
        }

        function form_submit()
        { 
            var token=true; 
            content = editor.getData(); 
            characterCount = getCharacterCount(content);
            roomName = $('#room_name').val();
            NameCount = getCharacterCount(roomName);

            $('#hotel_description_max_char').text(characterCount + '자 / 최대 ' + maxCharacterCount + '자'); 

            var token=true; 
            if(!field_required('room_name','room_name',"객실명은 필수 입력항목 입니다."))
                token = false;
            else if(NameCount > maxNameCount) 
            {
                setErrorAndErrorBox('room_name','객실명은 20자를 넘을 수 없습니다.');
                token = false;
            }
            if(!field_required('room_size','room_size',"객실크기는 필수 입력항목 입니다."))
                token = false;

            if(editor.getData() === '') {
                setErrorAndErrorBox('room_description','객실 설명은 필수 입력항목 입니다.');
                token = false;
            }
            else if(characterCount > maxCharacterCount) 
            {
                setErrorAndErrorBox('room_description','객실 설명은 500자를 넘을 수 없습니다.');
                token = false;
            }   
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                room_description:editor.getData()
                let formData = new FormData($("#room_basicinfo_form")[0])
                formData.append('room_description', editor.getData());

                $.ajax({
                    url: "{{ route('room_basicinfo_submit') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 1) {
                            window.location.href = data.nextpageurl;
                            unloading();
                        } else {
                            $(".form_submit").prop("disabled", false);
                            $('#hm_hm_server_err_msg').text(data.message);
                        }
                        unloading();
                    }
                });             
            }
        }
        // close
            // delete room other img
            $(document).on('click','.delRoomOtherImg',function(){
            var i = $(this).attr('data-i');
            $.post("{{ route('delRoomOtherImg') }}",{_token:"{{ csrf_token() }}",r:"{{ (isset($room->id))?$room->id:0 }}",i:i}, function(data){
                if(data.status==1)
                {
                    $("#room_img_"+i).hide();    
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
        // close delele room other img
        // mark featured room other img
        $(document).on('click','.markfeaturedhmimg',function(){
            var i = $(this).attr('data-i');
            $.post("{{ route('markFeaturedRoomImg') }}",{_token:"{{ csrf_token() }}",r:"{{ (isset($room->id))?$room->id:0 }}",i:i}, function(data){
                if(data.status==1)
                {
                    $('.markfeaturedhmimg').attr('class', 'markfeaturedhmimg fa fa-star-o favStar favStar-outline');
                    $('#featured_icon_'+i).attr('class', 'markfeaturedhmimg fa fa-star favStar favStar-fill');
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
        // close mark featured other img
    });
</script>
<script>
    var $modal = $('#roomOtherImgMdl');
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
                url: "{{ route('uploadRoomOtherImages') }}",
                data: {'_token': "{{ csrf_token() }}", 'image': base64data,r:"{{ (isset($room->id))?$room->id:0 }}"},
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
</script>
@endsection