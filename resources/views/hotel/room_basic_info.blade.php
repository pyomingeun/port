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
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.roomInfo') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-floating" id="room_name_validate">
                                                            <input type="text" class="form-control" placeholder="{{ __('home.roomName') }}" id="room_name"  name="room_name" value="{{ isset($room->room_name)?$room->room_name:''; }}">
                                                            <label for="room_name">{{ __('home.roomName') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="room_name_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="inpWtTextRtbg d-flex">
                                                            <div class="form-floating" id="room_size_validate">
                                                                <input type="text" class="form-control only_integer rightClickDisabled" placeholder="{{ __('home.roomSize') }}" id="room_size"  name="room_size" value="{{ isset($room->room_size)?$room->room_size:''; }}" >
                                                                <label for="room_size">Room Size<span class="required-star">*</span></label>
                                                                <p class="error-inp" id="room_size_err_msg"></p>
                                                            </div>
                                                            <span class="inpTextRtbg">sq m</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating editorField" id="room_description_validate">
                                                            <textarea  placeholder="{{ __('home.roomDescription') }}" class="ckeditor"  id="room_description"  name="room_description" value="{{ isset($room->room_description)?$room->room_description:''; }}" >{{ isset($room->room_description)?$room->room_description:''; }}</textarea>
                                                            <p class="mb-0 max-char-limit" id="room_description_max_char">max 2000 characters</p>
                                                            <p class="error-inp" id="room_description_err_msg"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt RoomImagesBox">
                                                <h5 class="hd5 h5">{{ __('home.roomImages') }}</h5>
                                                <div class="uploadImageRow d-flex align-items-center">
                                                    <input type="file" class="uploadinput otherimageinput" id="otherimageinput" >
                                                    <img src="{{asset('/assets/images/')}}/structure/upload-icon.svg" alt="" class="uploadIcon">
                                                    <div class="uploadImageDes">
                                                        <p class="p2 mb-2">{{ __('home.uploadRoomImages') }}<span class="required-star">*</span></p>
                                                        <p class="p4 mb-0">{{ __('home.uploadImageHereInFormat') }}</p>
                                                    </div>
                                                </div>
                                                <div class="hotelImgaesPreviewRow d-flex flex-wrap mt-4" id="otherimagessection">
                                                    @if(isset($room->hasImages) && count($room->hasImages) >0)
                                                    @foreach ($room->hasImages as $image)
                                                    <div class="hotelImgaesPreviewCol" id="room_img_{{$image->id}}">
                                                        <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon delRoomOtherImg"  data-i="{{$image->id}}">
                                                        <i class="{{ ($image->is_featured==1)?'fa fa-star favStar favStar-fill':'fa fa-star-o favStar favStar-outline'; }} markfeaturedhmimg" data-i="{{$image->id}}" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>" id="featured_icon_{{$image->id}}"></i>
                                                        <img src="{{ asset('/room_images/'.$image->room_image); }}"  alt="N.A." class="hotelPreviewImgae">
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="next" name="savetype" id="savetype">
                                    <div class="res-sub-btn-rw d-flex justify-content-end">
                                        <a class="btn bg-gray1" href="{{ route('rooms') }}">{{ __('home.cancel') }}</a>
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
                    <img id="otherimage" src="https://avatars0.githubusercontent.com/u/3456749">
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
@include('common_models')
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
    margin: 10px;
    border: 1px solid red;
    }
    .modal-lg{
    max-width: 1000px !important;
    } 
    #roomOtherImgMdl img
    {
    display: block;
    max-width: 100%;
    } 
    /* .preview2 {
    overflow: hidden;
    width: 200px; 
    height: 200px;
    margin: 10px;
    border: 1px solid red;
    }
    .modal-lg{
    max-width: 1000px !important;
    }*/
    </style>
<!-- JS section  -->   
@section('js-script')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<script type="text/javascript">
       CKEDITOR.replace( 'ckeditor', {
});
   CKEDITOR.config.removePlugins = 'Save,Print,Preview,image,Find,About,Maximize,ShowBlocks';
  </script>
<script>
    $(document).ready(function(){
        // form-validation and submit form  
        $(document).on('keyup','#room_name',function(){
        $("#hm_server_err_msg").text('');
            if(field_required('room_name','room_name',"Room name is required"))
            if(!checkMaxLength($('#room_name').val(),300 )) 
                setErrorAndErrorBox('room_name','Room name should be less than 300 letters.'); 
            else
                unsetErrorAndErrorBox('room_name');
        });
        $(document).on('keyup','#room_size',function(){
        $("#hm_server_err_msg").text('');
            if(field_required('room_size','room_size',"Room size is required"))
            if(!checkMaxLength($('#room_size').val(),200 )) 
                setErrorAndErrorBox('room_size','Room size should be less than 200 letters.'); 
            else
                unsetErrorAndErrorBox('room_size');
        });
        $(document).on('keyup','#room_description',function(){
            $("#hm_server_err_msg").text('');
            if(CKEDITOR.instances.room_description.getData() === '') {
                setErrorAndErrorBox('room_description','Hotel Description is required.');
            }
            else if(!checkMaxLength(CKEDITOR.instances.room_description.getData(),2000 )) 
            {
                setErrorAndErrorBox('room_description','Hotel Description should be less than 2000 letters.');
            }
            else
               unsetErrorAndErrorBox('room_description');
        }); 
        $(document).on('click','.form_submit',function(){
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        CKEDITOR.instances.room_description.on('change', function() { 
            $("#hm_server_err_msg").text('');
            let texlen = CKEDITOR.instances.room_description.getData().length; 
            $("#room_description_max_char").text(texlen+'/2000');
            if(CKEDITOR.instances.room_description.getData() === '') {
                setErrorAndErrorBox('room_description','Room Description is required.');
            }
            else if(texlen >2000) 
            {
                setErrorAndErrorBox('room_description','Room Description should be less than 2000 letters.');
            }
            else
               unsetErrorAndErrorBox('room_description');
        });
        function form_submit()
        { 
            var token=true; 
            if(!field_required('room_name','room_name',"Room name is required"))
                token = false;
            else if(!checkMaxLength($('#room_name').val(),300 )) 
            {
                setErrorAndErrorBox('room_name','Room name should be less than 300 letters.');
                token = false;
            }
            if(!field_required('room_size','room_size',"Room size is required"))
                token = false;
            else if(!checkMaxLength($('#room_size').val(),200 )) 
            {
                setErrorAndErrorBox('room_size','Room size should be less than 200 letters.');
                token = false;
            }
            if(CKEDITOR.instances.room_description.getData() === '') {
                setErrorAndErrorBox('room_description','Room Description is required.');
                token = false;
            }
            else if(!checkMaxLength(CKEDITOR.instances.room_description.getData(),2000 )) 
            {
                setErrorAndErrorBox('room_description','Room Description should be less than 2000 letters.');
                token = false;
            }   
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                let senddata = {room_name:$('#room_name').val(),room_size:$('#room_size').val(),room_description:CKEDITOR.instances.room_description.getData(),_token:"{{ csrf_token() }}",savetype:$('#savetype').val(),slug:"{{$slug}}"};
                $.post("{{ route('room_basicinfo_submit') }}",  senddata, function( data ) {
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
        // close mark featured other img
    });
</script>
<script>
    var $modal = $('#roomOtherImgMdl');
        var image = document.getElementById('otherimage');
        console.log(image);
        var cropper;
        $("body").on("change", ".otherimageinput", function(e){
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
        $("#cropother").click(function(){
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
                        url: "{{ route('uploadRoomOtherImages') }}",
                        data: {'_token': "{{ csrf_token() }}", 'image': base64data,r:"{{ (isset($room->id))?$room->id:0 }}"},
                        success: function(data){
                            if(data.status==1)
                            {
                                $('#otherimagessection').append(data.img);
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
 </script>
 <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection