@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->
    @php
       $feature_id = isset($feature->id)?$feature->id:0;
    @endphp
    <div class="main-wrapper-gray">
         @include('admin.leftbar')        
        <div class="content-box-right hotel-management-sec">

            <div class="container-fluid">
                <div class="hotel-management-row d-flex flex-wrap">
                   
                    <div class="hotel-management-right-col">
                        <div class="tab-content stepsContent">
                            <div class="">
                                <form id="amenitie_input" method="post" action="javascript:void(0)">
                                    <div class="hotelManageform-Content">
                                        <div class="grayBox-w">
                                            <div class="hotelmanageFormInrcnt">
                                                <h5 class="hd5 h5">Amenities Manage </h5>
                                                <div class="row">
                                                   
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-floating" id="amenitie_name_validate">
                                                            <input type="text" class="form-control a-enter-submit" id="amenitie_name" placeholder="Amenitie Name" name="amenitie_name" value="{{(isset($feature->feature_name))?$feature->feature_name:''; }}"  >
                                                            <label for="amenitie_name">Amenitie Name<span class="required-star">*</span></label>
                                                            <p class="error-inp" id="amenitie_name_err_msg"></p>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $feature_icon ='';
                                                    if(isset($feature->feature_icon) && $feature->feature_icon !='') 
                                                        $feature_icon = $feature->feature_icon;
                                                    @endphp                                                                        
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="hotelInfoRow d-flex align-items-center">
                                                            <div class="uploadhotelimageBox">
                                                                <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon cursor-p"  id="picDelcross" style="display:{{(isset($feature->feature_icon) && $feature->feature_icon !='' )?'block':'none'; }}">
                                                                
                                                                <img src="{{asset('/feature_icon/').'/'.$feature_icon }}" alt="" class="uploadhotelimage " id="myprofilepic"  style="display:{{(isset($feature->feature_icon) && $feature->feature_icon !='' )?'block':'none'; }}" >
                                                                
                                                                <img src="{{asset('/assets/images/')}}/structure/features_default_icon.png" alt="" class="uploadhotelimage" id="defaultprofilepic" style="display:{{ ( (isset($feature->feature_icon) && $feature->feature_icon =='' ) || $feature_id == 0 )?'block':'none'; }}">
                                                                <input type="file" class="uploadinput image"  name="logo" id="logo" accept="image/png, image/jpeg"> 
                                                            </div>
                                                            <div class="hotelInfoDes">
                                                                <p class="p2 mb-2">Amenitie Icon<span class="required-star">*</span></p>
                                                                <p class="p4 mb-0">Amenitie Icon Logo Here In JPG/PNG Format</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{ $feature_id; }}" name="id" id="id">
                                    <input type="hidden" value="" name="icon" id="icon">
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
<style type="text/css">
    #modal img {
    display: block;
    max-width: 100%;
    }
    .preview {
    overflow: hidden;
    width: 40px; 
    height: 40px;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            
            // login 
            $(document).on('keyup','.a-enter-submit',function(e){
                // console.log(e.keyCode);
                if(e.keyCode == 13)
                submit();
            });


            $(document).on('keyup','#amenitie_name',function(){
                $('#hm_server_err_msg').text('');
                field_required('amenitie_name','amenitie_name',"Amenitie name is required");
            });

            $(document).on('click','.form_submit',function(){
                $('#hm_server_err_msg').text('');
                $('#savetype').val($(this).attr('data-btntype')); 
                submit();
            });
             
            function submit()
            { 
                $("#hm_server_err_msg").text('');
                var token=true; 
          
                if(!field_required('amenitie_name','amenitie_name',"Amenitie name is required"))
                    token = false;
                else if(!checkMaxLength($('#amenitie_name').val(),200 )) 
                {
                    setErrorAndErrorBox('amenitie_name','Amenitie name should be less than 200 letters.');
                    token = false;
                }
                
                if(token)
                {
                   $(".form_submit").prop("disabled",true); 
                   loading();
                   
                    $(".form_submit").prop("disabled",true); 
                    $.post("{{ route('amenitie-input-submit') }}", $( "#amenitie_input" ).serialize() , function( data ) {
                        // console.log(data);
                        if(data.nextpageurl !=undefined && data.nextpageurl !=''){
                            window.location.href = data.nextpageurl; 
                        }
                        else
                        {
                            $("#commonErrorMsg").text(data.message);
                            $("#commonErrorBox").css('display','block');
                            $(".form_submit").prop("disabled",false); 
                            unloading();
                            setTimeout(function() {
                                $("#commonSuccessBox").hide();
                            }, 3000);
                             
                        }    
                        unloading();
                    });                   
                              
                }
            }
            // login close 

        });  
        
        // logo open 
        var modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".image", function(e){
            var files = e.target.files;
           // console.log(files[0].name);
            var done = function (url) {
            image.src = url;
            modal.modal('show');
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
        modal.on('shown.bs.modal', function () {
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
                width: 40,
                height: 40,
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
                        url: "{{ route('uploadFeatureIcon') }}",
                        data: {'_token': "{{ csrf_token() }}", 'image': base64data,id:3},
                        success: function(data){
                            if(data.status==1)
                            {
                                // unloading();
                                // location.reload();
                                var picurl = "{{asset('/feature_icon/'); }}";
                                picurl = picurl+'/'+data.logo;
                                $('#icon').val(data.logo);
                                $('#defaultprofilepic').css('display','none');
                                $('#picDelcross').css('display','block');
                                $('#myprofilepic').attr('src',picurl);   
                                // document.getElementById("myprofilepic").src=picurl;
                                $('#myprofilepic').css('display','block');
                                // 
                                /* $("#commonSuccessMsg").text(data.message);
                                $("#commonSuccessBox").css('display','block');
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000); */
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
                            modal.modal('hide');
                            // alert("success upload image");
                        }
                    });
                }
            });
        });    
        // logo close
        $(document).on('click','#picDelcross',function(e){
            $('#icon').val('');
            // $('#myprofilepic').attr('src',defaultpic);
            $('#myprofilepic').css('display','none');
            $('#defaultprofilepic').css('display','block');
            $('#picDelcross').css('display','none');

        });
    </script>   
    @endsection
