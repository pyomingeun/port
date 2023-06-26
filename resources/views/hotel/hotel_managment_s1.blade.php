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
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.hotelInfo') }} </h5>
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
                                                                <p class="p2 mb-2">{{ __('home.uploadLogo') }}<span class="required-star">*</span></p>
                                                                <p class="p4 mb-0">{{ __('home.uploadHotelLogoHereInFormat') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="hotel_name_validate">
                                                            <input type="text" class="form-control" id="hotel_name" placeholder="{{ __('home.hotelName') }}" name="hotel_name" value="{{$hotel->hotel_name}}">
                                                            <label for="hotel_name">{{ __('home.hotelName') }}<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="hotel_name_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating editorField"  id="hotel_description_validate">
                                                            <textarea  placeholder="{{ __('home.hotelDescription') }}" class="ckeditor" name="hotel_description" id="hotel_description" value="{{$hotel->description}}">{{$hotel->description}}</textarea>
                                                            <p class="mb-0 max-char-limit" id="hotel_description_max_char">max 2000 characters</p>
                                                            <p class="error-inp" id="hotel_description_err_msg"></p>
                                                            <p class="error-inp" id="hm_server_err_msg"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grayBox-w">
                                            <div class="hotemmanageFormInrcnt">
                                                <h5 class="hd5 h5">{{ __('home.uploadHotelImages') }}</h5>
                                                <div class="uploadImageRow d-flex align-items-center">
                                                    <input type="file" class="uploadinput otherimageinput" id="otherimageinput">
                                                    <img src="{{asset('/assets/images/')}}/structure/upload-icon.svg" alt="" class="uploadIcon">
                                                    <div class="uploadImageDes">
                                                        <p class="p2 mb-2">{{ __('home.uploadHotelImages') }}</p>
                                                        <p class="p4 mb-0">{{ __('home.uploadHotelImagesHereInFormat') }}</p>
                                                    </div>
                                                </div>
                                                <div class="hotelImgaesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection">
                                                    <!-- <div class="hotelImgaesPreviewCol">
                                                        <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon">
                                                        <i class="fa fa-star favStar favStar-fill" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>"></i>
                                                        <img src="{{asset('/assets/images/')}}/product/img1.png" alt="" class="hotelPreviewImgae">
                                                    </div> -->
                                                    @foreach ($hotel->hasImage as $image)
                                                    <div class="hotelImgaesPreviewCol" id="hotel_img_{{$image->id}}">
                                                    <div class="htlImageOverlay"></div>
                                                        <img src="{{ asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon delHotelOtherImg" data-i="{{$image->id}}">
                                                        <i class="markfeaturedhmimg {{ ($image->is_featured==1)?'fa fa-star favStar favStar-fill':'fa fa-star-o favStar favStar-outline'; }} " data-i="{{$image->id}}" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>" id="featured_icon_{{$image->id}}"></i>
                                                        <img src="{{ asset('/hotel_images/'.$image->image); }}" alt="N.A." class="hotelPreviewImgae">
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
                                        <a class="btn bg-gray1" href="{{ route('hm_cancel') }}" >{{ __('home.cancel') }}</a>
                                        <button type="button" class="btn outline-blue form_submit" data-btntype="save_n_exit" >{{ __('home.SaveExit') }}</button>
                                        <button type="button" class="btn btnNext tab1 form_submit" data-btntype="next">{{ __('home.NextContinue') }}</button>
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
        <!-- <h5 class="modal-title" id="modalLabel">Laravel Crop Image Before Upload using Cropper JS - NiceSnippets.com</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('home.cancel') }}</button>
        <button type="button" class="btn btn-primary" id="crop">{{ __('home.Crop') }}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hotelOtherImgMdl" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
<style>
    .sidebar-menu-ul .nav-item .nav-link {
        opacity: 0.7;
        pointer-events: none;
    }
    .sidebar-menu-ul .nav-item.active .nav-link {
        opacity: 1;
        pointer-events: unset;
    }
</style>    
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
    #hotelOtherImgMdl img
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
<!-- <script src="//cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    //editor
    // $(document).ready(function () { $('.ckeditor').ckeditor(); });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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
})
</script>
<script type="text/javascript">
       CKEDITOR.replace( 'ckeditor', {
});
   CKEDITOR.config.removePlugins = 'Save,Print,Preview,image, Find,About,Maximize,ShowBlocks';
  </script>
<script>
        $(document).ready(function(){
        // $('.clockpicker').clockpicker({
        //     'default': 'now',
        //     twelvehour: true,
        //     autoclose: true
        // });
        /*    
        $(document).ready(function($) {
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
        });
        */
        // Add service
        $(document).ready(function() {
            $(".addServiceBtn").click(function() {
                $(".addServiceContent").show();
                $(".addDiscountContent").hide();
                $(".addSeasonContent").hide();
            });
            $(".addDiscountBtn").click(function() {
                $(".addServiceContent").hide();
                $(".addDiscountContent").show();
                $(".addSeasonContent").hide();
            });
            $(".addSeasonBtn").click(function() {
                $(".addServiceContent").hide();
                $(".addDiscountContent").hide();
                $(".addSeasonContent").show();
            });
        });
        // form-validation and submit form  
        $(document).on('keyup','#hotel_name',function(){
                $("#hm_server_err_msg").text('');
                 if(field_required('hotel_name','hotel_name',"Hotel name is required"))
                    if(!checkMaxLength($('#hotel_name').val(),300 )) 
                        setErrorAndErrorBox('hotel_name','Hotel name should be less than 300 letters.'); 
                    else
                        unsetErrorAndErrorBox('hotel_name');
        });
        /* $(document).on('keyup','#hotel_description',function(){
            $("#hm_server_err_msg").text('');
            if(CKEDITOR.instances.hotel_description.getData() === '') {
                setErrorAndErrorBox('hotel_description','Hotel Description is required.');
            }
            else if(!checkMaxLength(CKEDITOR.instances.hotel_description.getData(),2000 )) 
            {
                setErrorAndErrorBox('hotel_description','Hotel Description should be less than 2000 letters.');
            }
            else
               unsetErrorAndErrorBox('hotel_description');
        }); */
        $(document).on('click','.form_submit',function(){
            $('#hm_hm_server_err_msg').text('');
            // alert('dfsf');
            $('#savetype').val($(this).attr('data-btntype'));
            form_submit();
        });
        CKEDITOR.instances.hotel_description.on('change', function() { 
            $("#hm_server_err_msg").text('');
            let texlen = CKEDITOR.instances.hotel_description.getData().length; 
            $("#hotel_description_max_char").text(texlen+'/2000');
            if(CKEDITOR.instances.hotel_description.getData() === '') {
                setErrorAndErrorBox('hotel_description','Hotel Description is required.');
            }
            else if(texlen >2000) 
            {
                setErrorAndErrorBox('hotel_description','Hotel Description should be less than 2000 letters.');
            }
            else
               unsetErrorAndErrorBox('hotel_description');
        });
        function form_submit()
        { 
            var token=true; 
           //  var CKEDITOR = new CKEditor();
            // var hotel_description = ClassicEditor.instances.hotel_description.getData();
            // console.log(hotel_description);
            if(!field_required('hotel_name','hotel_name',"Hotel name is required"))
                token = false;
            else if(!checkMaxLength($('#hotel_name').val(),300 )) 
            {
                setErrorAndErrorBox('hotel_name','Hotel name should be less than 300 letters.');
                token = false;
            }
            if(CKEDITOR.instances.hotel_description.getData() === '') {
                setErrorAndErrorBox('hotel_description','Hotel Description is required.');
                token = false;
            }
            else if(!checkMaxLength(CKEDITOR.instances.hotel_description.getData(),2000 )) 
            {
                setErrorAndErrorBox('hotel_description','Hotel Description should be less than 2000 letters.');
                token = false;
            }   
            if(token)
            {
                $(".form_submit").prop("disabled",true); 
                loading();
                //  let formdata = $( "#hm_basic_info_form" ).serialize();
                // formdata.hotel_description = CKEDITOR.instances.hotel_description.getData()
                let senddata = {hotel_name:$('#hotel_name').val(),hotel_description:CKEDITOR.instances.hotel_description.getData(),h:$('#h').val(),_token:$('#tk').val(),savetype:$('#savetype').val()};
                $.post("{{ route('hm_basic_info_submit') }}",  senddata, function( data ) {
                            // console.log(data);
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
        // logo open 
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
        // logo close 
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
        // close delele logo
        // delete hotel other img
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
        // close delele hotel other img
        // mark featured hotel other img
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
        // close mark featured other img        
        // CKEDITOR.replace( 'hotel_description', {
        //      removePlugins: 'basicstyles,justify'
        // });
/*
// other img open 
var $modal2 = $('#hotelOtherImgMdl');
var image2 = document.getElementById('otherimage');
var cropper2;
$("body").on("change", ".otherimage", function(e){
    var files2 = e.target.files;
    var done2 = function (url) {
    image2.src = url;
    $modal2.modal('show');
    };
    var reader2;
    var file2;
    var url2;
    if (files2 && files2.length > 0) {
    file2 = files2[0];
    if (URL) {
        done2(URL.createObjectURL(file2));
    } else if (FileReader) {
        reader2 = new FileReader();
        reader2.onload = function (e) {
        done2(reader2.result);
        };
        reader2.readAsDataURL(file2);
    }
    }
});
$modal2.on('shown.bs.modal', function () {
    cropper2 = new Cropper(image, {
    aspectRatio: 1,
    viewMode: 3,
    preview: '.preview2'
    });
}).on('hidden.bs.modal', function () {
cropper2.destroy();
cropper2 = null;
});
$("#cropother").click(function(){
    loading();
    canvas2 = cropper2.getCroppedCanvas({
        width: 160,
        height: 160,
    });
    canvas2.toBlob(function(blob) {
        url2 = URL.createObjectURL(blob);
        var reader2 = new FileReader();
        reader2.readAsDataURL(blob); 
        reader2.onloadend = function() {
            var base64data2 = reader2.result;	
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('uploadHotelOtherImages') }}",
                data: {'_token': "{{ csrf_token() }}", 'image': base64data2,h:"{{ $hotel->hotel_id}}"},
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
                    $modal2.modal('hide');
                    // alert("success upload image");
                }
            });
        }
    });
});    
// other img close
*/
    });    
    </script>
<script>
    var $modal = $('#hotelOtherImgMdl');
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
                        url: "{{ route('uploadHotelOtherImages') }}",
                        data: {'_token': "{{ csrf_token() }}", 'image': base64data,h:"{{ $hotel->hotel_id}}"},
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
@endsection