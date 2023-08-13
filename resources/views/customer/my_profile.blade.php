@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
<!-- include left bar here -->
        @include('customer.leftbar')
        <div class="content-box-right profile-sec">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 profile-left-col">
                        <div class="profile-left-inner-col">
                            <!-- <div class="profileImageBlock">
                                <img src="{{asset('/assets/images/')}}/structure/profile-default-img.png" alt="" class="profileImage">
                            </div> -->
                            <div class="profileImageBlock d-flex align-items-center justify-content-center">
                            <img src="{{asset('/assets/images/')}}/structure/cross-red.svg" alt="" class="ProfileImgDeleteIcon cursor-p" id="picDelcross" style="display:{{($user->profile_pic !='' )?'block':'none'; }}">
                            <img src="{{asset('/profile_pic/'.$user->profile_pic); }}" alt="" class="profileImage" id="myprofilepic" style="display:{{($user->profile_pic !='' )?'block':'none'; }}">
                            <img src="{{asset('/assets/images/')}}/structure/profile_default.png" alt="" class="profileImage" id="defaultprofilepic" style="display:{{($user->profile_pic =='' )?'block':'none'; }}" >
                            <!-- <div class="prNameText text-capitalize">K</div> -->
                             <input type="file" class="uploadInput image" name="profile_pic" id="profile_pic" accept="image/png, image/jpeg">
                            </div>          
                            <!-- <div class="profileImageBlock">
                  <img src="{{asset('/assets/images/')}}/structure/cross-red.svg" alt="" class="ProfileImgDeleteIcon cursor-p">
                  <img src="{{asset('/assets/images/')}}/product/p1.png" alt="" class="profileImage">
                </div> -->
                            <h5 class="h5 text-center text-capitalize" id="full_name_txt2">{{$user->full_name}}</h5>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 profile-right-col">
                        <div class="profile-right-inner-col">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <h6 class="h6">{{ __('home.personalDetails') }}</h6>
                                <button class="deleteBtn d-flex align-items-center ml-auto" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/delete.svg" alt="" class="deleteIcon"> {{ __('home.deleteAccount') }}</button>
                            </div>
                            <div class="profile-dtl-row">
                                <div class="row nameRow">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                        <p class="p1" style="color: #191C1A;">{{ __('home.fullName') }}</p>
                                    </div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-12 d-flex align-items-center">
                                        <p class="p1 text-capitalize" style="color: #717972;" id="full_name_txt">{{$user->full_name}}</p>
                                    </div>
                                    <div class="col-xl-1 col-lg-2 col-md-1 col-sm-2 col-12 text-right">
                                        <img src="{{asset('/assets/images/')}}/structure/edit-sq.svg" class="cursor-p editName">
                                    </div>
                                </div>
                                <div class="profile-edit-form-rw editNameForm">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12">
                                            <h6 class="h6 mb-2">{{ __('home.fullName') }}</h6>
                                            <p class="p2">{{ __('home.enterYourNewFullname') }}</p>
                                            <form method="post" action="javaScript:Void(0);">
                                                <div class="form-floating"  id="e_cp_full_name_validate">
                                                    <input type="text" class="form-control onpress_enter_up_cp text-capitalize" id="e_cp_full_name" placeholder="{{ __('home.fullName') }}" value="{{$user->full_name}}"  data-field="full_name">
                                                    <label for="e_cp_full_name">{{ __('home.fullName') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="e_cp_full_name_err_msg"></p>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <a class="cursor-p cancelName">{{ __('home.cancel') }}</a>
                                                    <button type="button" class="btn update_cp" data-field="full_name" >{{ __('home.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-dtl-row">
                                <div class="row emailRow">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                        <p class="p1" style="color: #191C1A;">email</p>
                                    </div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-12 d-flex align-items-center">
                                        <p class="p1" style="color: #717972;" id="email_txt">{{$user->email}}</p>
                                    </div>
                                    <div class="col-xl-1 col-lg-2 col-md-1 col-sm-2 col-12 text-right">
                                        <img src="{{asset('/assets/images/')}}/structure/edit-sq.svg" class="cursor-p editEmail">
                                    </div>
                                </div>
                                <div class="profile-edit-form-rw editEmailForm">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12">
                                            <h6 class="h6 mb-2">{{ __('home.email') }}</h6>
                                            <p class="p2">{{ __('home.enterYourNewEmail') }}</p>
                                            <form method="post" action="javaScript:Void(0);">
                                                <div class="form-floating"  id="e_cp_email_validate">
                                                    <input type="email" class="form-control onpress_enter_up_cp" id="e_cp_email" placeholder="{{ __('home.email') }}" value="{{$user->email}}" data-field="email">
                                                    <label for="e_cp_email">{{ __('home.email') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="e_cp_email_err_msg"></p>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <a class="cursor-p cancelEmail">{{ __('home.cancel') }}</a>
                                                    <button type="button" class="btn update_cp" data-field="email" >{{ __('home.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-dtl-row">
                                <div class="row phoneRow">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 d-flex align-items-center">
                                        <p class="p1" style="color: #191C1A;" >{{ __('home.phone') }}</p>
                                    </div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-12 d-flex align-items-center">
                                        <p class="p1" style="color: #717972;" id="phone_txt">{{$user->phone}}</p>
                                    </div>
                                    <div class="col-xl-1 col-lg-2 col-md-1 col-sm-2 col-12 text-right">
                                        <img src="{{asset('/assets/images/')}}/structure/edit-sq.svg" class="cursor-p editPhone">
                                    </div>
                                </div>
                                <div class="profile-edit-form-rw editPhoneForm">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12">
                                            <h6 class="h6 mb-2">{{ __('home.phone') }}</h6>
                                            <p class="p2">{{ __('home.enterYourNewPhone') }}</p> <!--  & we’ll send otp to verify. -->
                                            <form method="post" action="javaScript:Void(0);">
                                                <div class="form-floating"  id="e_cp_phone_validate">
                                                    <input type="text" class="form-control onpress_enter_up_cp phone_number_input rightClickDisabled" id="e_cp_phone" placeholder="{{ __('home.phone') }}" value="{{$user->phone}}" data-field="phone" >
                                                    <label for="e_cp_phone">{{ __('home.phone') }}<span class="required-star">*</span></label>
                                                    <p class="error-inp" id="e_cp_phone_err_msg"></p>
                                                    <p class="error-inp" style="color:green;" id="e_cp_phone_success_msg"></p>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <a class="cursor-p cancelPhone">{{ __('home.cancel') }}</a>
                                                    <button class="btn update_cp" data-field="phone" type="button" >{{ __('home.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <!--Thank you Modal -->
    <div class="modal fade thankyouDialog successDialog" tabindex="-1" aria-labelledby="thankyouDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <div class="text-center">
                            <img src="{{asset('/assets/images/')}}/structure/checked-thankyou.svg" alt="" class="">
                            <h3 class="h3 mt-2">{{ __('home.thankYou') }}!</h3>
                            <p class="p2 mb-4">{{ __('home.pleaseClickTheLinkWeHaveSentOn') }} <span id="new_email"></span> {{ __('home.toTpdateTourEmailAddress') }}</p>
                        </div>
                        <a  class="btn w-100 cancelEmail" data-bs-dismiss="modal" aria-label="Close">{{ __('home.OK') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal -->
    <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-heads">
                        <h3 class="h3 mt-2">{{ __('home.deleteAccount') }}</h3>
                        <p class="p2 mb-4">{{ __('home.areYouSureYouWantToDeleteYourAccount') }}</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <a href="{{ route('deleteMyAcccount') }}" class="btn bg-gray flex-fill">{{ __('home.yes') }}</a>
                        <button class="btn flex-fill" data-bs-dismiss="modal">{{ __('home.no') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" >
        <img src="" style="width: 100%" id="cropper-image" alt="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div> -->
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
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
    margin: 10px;
    border: 1px solid red;
    }
    .modal-lg{
    max-width: 1000px !important;
    }
    </style>
     <!-- JS section  -->   
     @section('js-script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#e_cp_phone').mask('000-0000-0000');
            $(".editName").click(function() {
                $(".editNameForm").show();
                $(".nameRow").hide();
                unsetErrorAndErrorBox('e_cp_full_name');
            });
            $(".cancelName").click(function() {
                $("#e_cp_full_name").val($("#full_name_txt").text());
                $(".editNameForm").hide();
                $(".nameRow").show();
                unsetErrorAndErrorBox('e_cp_full_name');
            });
            $(".editEmail").click(function() {
                $(".editEmailForm").show();
                $(".emailRow").hide();
                unsetErrorAndErrorBox('e_cp_email');
            });
            $(".cancelEmail").click(function() {
                $("#e_cp_email").val($("#email_txt").text());
                $(".editEmailForm").hide();
                $(".emailRow").show();
                unsetErrorAndErrorBox('e_cp_email');
            });
            $(".editPhone").click(function() {
                $(".editPhoneForm").show();
                $(".phoneRow").hide();
                unsetErrorAndErrorBox('e_cp_phone');
            });
            $(".cancelPhone").click(function() {
                $("#e_cp_phone").val($("#phone_txt").text());
                $(".editPhoneForm").hide();
                $(".phoneRow").show();
                unsetErrorAndErrorBox('e_cp_phone');
            });
        // login 
        $(document).on('keyup','.onpress_enter_up_cp',function(e){
            // console.log(e.keyCode);
            if(e.keyCode == 13)
            {
                var field =  $(this).attr('data-field');
                customer_profile_update(field);
            }
        });    
        $(document).on('click','.update_cp',function(){
            var field =  $(this).attr('data-field');
            console.log(field);
                customer_profile_update(field);
        });
        $(document).on('keyup','#e_cp_full_name',function(){
            // $("#server_err_msg").text('');
                if(field_required('e_cp_full_name','e_cp_full_name',"Full Name is required"))
                if(!checkMaxLength($('#e_cp_full_name').val(),200 )) 
                    setErrorAndErrorBox('e_cp_full_name','Full Name should be less than 200 letters.'); 
                else
                    unsetErrorAndErrorBox('e_cp_full_name');
        });
        $(document).on('keyup','#e_cp_email',function(){
                // $("#server_err_msg").text('');
                if(field_required('email','e_cp_email',"Email is required"))
                    if(!isEmail($('#e_cp_email').val())) 
                        setErrorAndErrorBox('e_cp_email','Please enter a valid email.'); 
                    else
                    {
                        unsetErrorAndErrorBox('e_cp_email'); 
                        // checkEmailIsExist($('#e_cp_email').val());
                    }
        });
        $(document).on('keyup','#e_cp_phone',function(){
            // $("#server_err_msg").text('');
            if(field_required('e_cp_phone','e_cp_phone',"Phone number is required"))
                if(!checkExactLength($("#e_cp_phone").val(),13))
                        setErrorAndErrorBox('e_cp_phone','Please enter a valid phone number.'); 
                    else
                        unsetErrorAndErrorBox('e_cp_phone');    
        });
        function customer_profile_update(field)
        { 
            //  $("#server_err_msg").text('');
            // console.log('customer_profile_update'+field);
            var token=true; 
            if(field == 'full_name')
            {
                if(!field_required('e_cp_full_name','e_cp_full_name',"Full Name is required"))
                token = false;
                else if(!checkMaxLength($('#e_cp_full_name').val(),200 )) 
                {
                    setErrorAndErrorBox('e_cp_full_name','Full Name should be less than 200 letters.');
                    token = false;
                } 
            }
            else if(field == 'email')
            {
                if(!field_required('e_cp_email','e_cp_email',"Email is required"))
                token = false;
                else if(!isEmail($('#e_cp_email').val())) 
                {   
                    setErrorAndErrorBox('e_cp_email','Please enter a valid email.');
                    token = false;
                }    
            } 
            else
            {
                if(!field_required('e_cp_phone','e_cp_phone',"Phone number is required"))
                token = false;
                else if(!checkExactLength($("#e_cp_phone").val(),13))
                {   
                    setErrorAndErrorBox('e_cp_phone','Please enter a valid phone number.');
                    token =false;  
                }
                else
                    unsetErrorAndErrorBox('e_cp_phone');
            }
            if(token)
            {
                   $(".update_cp").prop("disabled",true); 
                   loading();
                   var val = $('#e_cp_'+field).val();
                   var id = "{{ auth()->user()->id; }}";
                   var e = "{{ auth()->user()->email; }}";
                   if(field !='email')
                   {
                        if(field !=undefined && field !='')
                        {
                            $.post("{{ route('customer_profile_update') }}",{field:field,val:val,t:id,e:e}, function(data){
                            if(data.status==0)
                            {
                                $("#e_cp_"+field+'_err_msg').text(data.message);    
                                $(".update_cp").prop("disabled",false); 
                                unloading(); 
                            }
                            else
                            {
                                // $("#e_cp_"+field+'_success_msg').text(data.message);
                                $("#commonSuccessMsg").text(data.message);
                                // $("#commonSuccessBox").css('display','block');
                                $("#commonSuccessBox").css('display','block');
                                setTimeout(function() {
                                    $("#commonSuccessBox").hide();
                                }, 3000);
                                if(field == 'full_name')
                                {
                                    $(".editNameForm").hide();
                                    $(".nameRow").show();
                                    var val = $("#e_cp_full_name").val();
                                    var val3 = val;
                                    if(val3.length >8)
                                    {
                                        val3 = val3.substring(0, 8)+"..";
                                    } 
                                    $("#full_name_txt").text(val);   
                                    $("#full_name_txt2").text(val);   
                                    $("#full_name_txt3").text(val3);   
                                }
                                else
                                {
                                    $(".editPhoneForm").hide();
                                    $(".phoneRow").show();
                                    var val = $("#e_cp_phone").val();
                                    $("#phone_txt").text(val);
                                }
                                $(".update_cp").prop("disabled",false); 
                                unloading();
                            }        
                        });
                        }
                        else 
                        { unloading();}
                   }
                   else if(field ='email')
                   {
                        $(".update_cp").prop("disabled",true); 
                        loading();
                        var email = $('#e_cp_email').val();
                        $.post("{{ route('reg_emailcheck') }}",{email:email}, function(data){
                            if(data.status==0)
                            {
                                setErrorAndErrorBox('e_cp_email',data.message);    
                                $(".update_cp").prop("disabled",false); 
                                unloading(); 
                            }
                            else
                            {
                                $(".update_cp").prop("disabled",true); 
                                $.post("{{ route('email_change_req') }}", {email:email,_token:"{{ csrf_token() }}"} , function( data ) {
                                    // console.log(data);
                                    if(data.nextpageurl !=undefined && data.nextpageurl ==''){
                                        // window.location.href = data.nextpageurl;
                                        $(".editEmailForm").hide();
                                        $(".emailRow").show();
                                        $('.thankyouDialog').modal('show');  
                                        $('#new_email').text(email);
                                        setTimeout(function() {
                                            $(".thankyouDialog").modal('hide');
                                        }, 10000);
                                    }
                                    else
                                    {
                                        $("#commonErrorMsg").text(data.message);
                                        // $("#commonSuccessBox").css('display','block');
                                        $("#commonErrorBox").css('display','block');
                                        setTimeout(function() {
                                            $("#commonErrorBox").hide();
                                        }, 3000);
                                        $(".update_cp").prop("disabled",false); 
                                    }    
                                    unloading();
                                });
                            }        
                        });
                   }
            }
            else
            { 
                console.log('token'+token); 
            } 
        }
        $(document).on('click','#picDelcross',function(){
            $.post("{{ route('deleteMyProfilePic') }}",{_token:"{{ csrf_token() }}"}, function(data){
                if(data.status==1)
                {
                    $('#defaultprofilepic').css('display','block');
                    $('#picDelcross').css('display','none');
                    $('#myprofilepic').css('display','none');
                    $('#myprofilepic').attr('src',"{{asset('/profile_pic/'.$user->profile_pic); }}");
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
        // crop 
        // $(document).on('change','#profile_pic', function(){
        //     var reader = new FileReader();
        //     reader.onload = function (event) {
        //         img = new Image();
        //         img.src = event.target.result;
        //         $('#cropper-image').attr("src", event.target.result);
        //         const cropperBody = $('#cropper-image')
        //         $('#myModal').modal('show');
        //         const cropper = new Cropper(event.target.result, {
        //             aspectRatio: 16 / 9,
        //             crop(event) {
        //                 console.log(event);
        //             }
        //         })
        //         // 
        //     }
        //     reader.readAsDataURL(this.files[0]);
        // //-------
        // });
        });
        $(document).ready(function(){
        //     $(document).on('change','#profile_pic', function(){
        //     var reader = new FileReader();
        //     reader.onload = function (event) {
        //         img = new Image();
        //         img.src = event.target.result;
        //         $('#cropper-image').attr("src", event.target.result);
        //         $('#myModal').modal('show');
        //         $('#cropper-image').Jcrop({
        //             aspectRatio: 1,
        //             onSelect: function(c, e){
        //                 console.log(c);
        //                 size = {x:c.x,y:c.y,w:c.w,h:c.h};
        //                 $("#crop").css("visibility", "visible");     
        //             }
        //         });
        //         // 
        //     }
        //     reader.readAsDataURL(this.files[0]);
        // //-------
        // });
        });
    </script>
<script>
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
                url: "{{ route('uploadProfilePic') }}",
                data: {'_token': "{{ csrf_token() }}", 'image': base64data},
                success: function(data){
                    if(data.status==1)
                    {
                        // unloading();
                        // location.reload();
                        var picurl = "{{asset('/profile_pic/'); }}";
                        picurl = picurl+'/'+data.pic;
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
})
</script>
    @endsection