@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')

  <div class="main-wrapper-gray">
    @include('admin.leftbar')
    <div class="content-box-right hotel-management-sec">
      <div class="container-fluid">
        <div class="hotel-management-row d-flex flex-wrap">
        	<div class="hotel-management-left-col">
        	  <div class="hotel-tabs-rw">
        	    <ul class="nav nav-tabs">
        	      <li class="nav-item">
        	        <a class="nav-link tab1 active" role="tab" data-bs-toggle="tab" href="#step1">
        	          <span class="stepcircle">1 <img src="{{asset('/assets/images/')}}/structure/tick-square.svg" class="setepCeckIcon"></span>
        	          <div class="tabCnt">
        	          	<p class="p3">Step 1</p>
        	          	<p class="p1">Post</p>
        	          </div>
        	        </a>
        	      </li>
        	    </ul>
        	  </div>
        	</div>
          <div class="hotel-management-right-col">
            <div class="tab-content stepsContent">
              <div class="tab-pane active" id="step1">
                <form id="post_input" action="{{ isset($post) ? route('admin-post-update', $post->id):route('admin-post-store') }}" method="post">
                  @csrf
                  <div class="create-coupon-code-sec">
                    <div class="grayBox-w">
                      <div class="hotelInfoRow d-flex align-items-center">
                        <div class="uploadhotelimageBox">
                          <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon cursor-p"  id="picDelcross" style="display: none">
                          <img src="{{
                            isset($post) ?asset($post->image) :asset('/assets/images/structure/hotel_default.png')
                          }}" alt="" class="uploadhotelimage" id="defaultprofilepic" style="display: block">
                          <input type="file" class="uploadinput image"  name="logo" id="logo" accept="image/png, image/jpeg">         
                          <textarea name="thumbimage" id="thumbimage" style="display: none">{{ isset($post) ?$post->image:'' }}</textarea>      
                          <textarea name="otherimageP" id="otherimageP" style="display: none">{{ isset($images) ? json_encode($images) :'' }}</textarea>
                        </div>
                        <div class="hotelInfoDes" style="position: relative">
                          <p class="p2 mb-2">Upload Thumbnail Image<span class="required-star">*</span></p>
                          <p class="p4 mb-0">Upload Thumbnail Image here in JPG/PNG format</p>
                          <p class="error-inp" id="thumbimage_err_msg"></p>
                        </div>
                      </div>
                      <div class="hotemmanageFormInrcnt">
                        <h5 class="hd5 h5">Post Title</h5>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating">
                              <input type="text" class="form-control" placeholder="Post Title" name="post_title" id="post_title" value="{{ isset($post)?$post->title:'' }}" >
                              <label for="post_title">Post Title<span class="required-star">*</span></label>
                              <p class="error-inp" id="post_title_err_msg"></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="hotemmanageFormInrcnt">
                            <h5 class="hd5 h5">Post Type</h5>
                            <div class="row">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-floating mb-3" id="h_validate">
                                  <button id="PostType" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false"></button>
                                  <label for="PostType" class="label">Post Type<span class="required-star">*</span></label>
                                  <ul class="dropdown-menu dropdown-menu-start">
                                    <li class="radiobox-image">
                                      <input type="radio" class="PostType" id="magazine" name="PostType" value="magazine" />
                                      <label for="magazine">Magazine</label>
                                    </li>
                                    <li class="radiobox-image">
                                      <input type="radio" class="PostType" name="PostType" id="event" value="events"/>
                                      <label for="event">Event</label>
                                    </li>
                                  </ul>
                                  <p class="error-inp" id="PostType_err_msg"></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="hotemmanageFormInrcnt">
                            <h5 class="hd5 h5">Post Status</h5>
                            <div class="row">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-floating mb-3" id="h_validate">
                                  <button id="PostStatus" data-bs-toggle="dropdown" class="form-select text-capitalize" aria-expanded="false"></button>
                                  <ul class="dropdown-menu dropdown-menu-start">
                                    <li class="radiobox-image">
                                      <input type="radio" class="PostStatus" id="draft" name="PostStatus" value="draft" />
                                      <label for="draft">Draft</label>
                                    </li>
                                    <li class="radiobox-image">
                                      <input type="radio" class="PostStatus" name="PostStatus" id="active" value="active"/>
                                      <label for="active">Active</label>
                                    </li>
                                    <li class="radiobox-image">
                                      <input type="radio" class="PostStatus" name="PostStatus" id="inactive" value="inactive"/>
                                      <label for="inactive">Inactive</label>
                                    </li>
                                  </ul>
                                  <label for="PostStatus" class="label">Post Status<span class="required-star">*</span></label>
                                  <p class="error-inp" id="PostStatus_err_msg"></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hotemmanageFormInrcnt">
                        <h5 class="hd5 h5">Upload Other Images</h5>
                        <div class="uploadImageRow d-flex align-items-center">
                          <input type="file" class="uploadinput otherimageinput" id="otherimageinput">
                          <img src="{{asset('/assets/images/')}}/structure/upload-icon.svg" alt="" class="uploadIcon">
                          <div class="uploadImageDes">
                            <p class="p2 mb-2">Upload Other Images</p>
                            <p class="p4 mb-0">Upload Other Images here in JPG/PNG format</p>
                          </div>
                        </div>
                        <span id="otherImagePreview"></span>
                      </div>

											<div class="hotemmanageFormInrcnt" id="PostContentBox">
                        <h5 class="hd5 h5">Post Content</h5>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-floating">
															<textarea  class="ckeditor" placeholder="Post Content" name="post_content" id="post_content" cols="30" rows="10">{{ isset($post) ? $post->content: '' }}</textarea>
                              <p class="error-inp" id="post_content_err_msg"></p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="res-sub-btn-rw d-flex justify-content-end">
                    <a href="{{ route('admin-post-list'); }}" class="btn bg-gray1">Cancel</a>
                    <button class="btn form_submit" id="submitPost" type="submit">Save</button>
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

  <div class="modal fade" id="hotelOtherImgMdl" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="cropother">Crop</button>
        </div>
      </div>
    </div>
  </div>

<!-- common models -->
@include('common_models')

@include('frontend.layout.footer_script')
@endsection

<!-- JS section  -->   
@section('js-script')

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script src="https://rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

<script type="text/javascript">
	CKEDITOR.replace( 'ckeditor', {});
	CKEDITOR.config.removePlugins = 'Save,Print,Preview,image,Find,About,Maximize,ShowBlocks';
</script>

<script>
  $(document).ready(function() {
    CKEDITOR.instances.post_content.on('change', function() {
      let texlen = CKEDITOR.instances.post_content.getData().length; 
      if(CKEDITOR.instances.post_content.getData() === '') {
        setErrorAndErrorBox('post_content','Post Content is required.');
      } else {
        unsetErrorAndErrorBox('post_content');
      }
    });
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
        const extention = file.type.split('/')[1];
        if (extention !== 'jpeg' && extention !== 'png' && extention !== 'jpg') {
          alert('Please upload image in jpg/png format');
        } else {
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
          picurl = base64data;
          $('#picDelcross').css('display','block');
          $('#defaultprofilepic').attr('src',picurl);
          $('#thumbimage').val(picurl);
          unloading();
          $modal.modal('hide');
        }
      });
    });
    $(document).on('click','#picDelcross',function(){
      $('#defaultprofilepic').attr('src',"{{asset('/assets/images/')}}/structure/hotel_default.png");
      $('#thumbimage').val('');
      $('#picDelcross').css('display','none');
    });
  });
</script>

<script>
  var $modal = $('#hotelOtherImgMdl');
  var image = document.getElementById('otherimage');
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
      const extention = file.type.split('/')[1];
        if (extention !== 'jpeg' && extention !== 'png' && extention !== 'jpg') {
          alert('Please upload image in jpg/png format');
        } else {
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
  function markUnmark(index, type) {
    let otherimage = $('#otherimageP').val();
    let otherimages = otherimage !== '' ? JSON.parse($('#otherimageP').val()) : [];
    otherimages[index].isFeatured = type;
    let i = 0;
    let images = '';
    otherimages.forEach(element => {
      images += `
      <div class="hotelImgaesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection${i}">
        <div class="hotelImgaesPreviewCol">
          <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon"
            onclick="removeImage(${i})"
          >
          <i
            class="fa fa-star favStar ${element.isFeatured === 1 ? 'favStar-fill': 'favStar-outline'}"
            aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true"
            onclick="markUnmark(${i}, ${element.isFeatured === 1? 0: 1})"
            title="<div class='tooltipbox centerArrowTT'>
            <small class='mediumfont'>${element.isFeatured === 1 ? 'Unmark as Featured': 'Mark as Featured'}</small> </div>">
          </i>
          <img src="${element.image}" alt="" class="hotelPreviewImgae">
        </div>
      </div>`;
      i++;
    });
    $('#otherImagePreview').html(images);
    $('#otherimageP').val(JSON.stringify(otherimages));
  }
  function removeImage(index) {
    let otherimage = $('#otherimageP').val();
    let otherimages = otherimage !== '' ? JSON.parse($('#otherimageP').val()) : [];
    otherimages.splice(index, 1);
    let i = 0;
    let images = '';
    otherimages.forEach(element => {
      images += `
      <div class="hotelImgaesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection${i}">
        <div class="hotelImgaesPreviewCol">
          <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon"
            onclick="removeImage(${i})"
          >
          <i
            class="fa fa-star favStar ${element.isFeatured === 1 ? 'favStar-fill': 'favStar-outline'}"
            aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true"
            onclick="markUnmark(${i}, ${element.isFeatured === 1? 0: 1})"
            title="<div class='tooltipbox centerArrowTT'>
            <small class='mediumfont'>${element.isFeatured === 1 ? 'Unmark as Featured': 'Mark as Featured'}</small> </div>">
          </i>
          <img src="${element.image}" alt="" class="hotelPreviewImgae">
        </div>
      </div>`;
      i++;
    });
    $('#otherImagePreview').html(images);
    $('#otherimageP').val(JSON.stringify(otherimages));
  }

  function showOtherImages(otherimages) {
    let i = 0;
    let images = '';
    otherimages.forEach(element => {
      let image = element.image;
      if (element.type !== 'base64') {
        image = "{{asset('/')}}/"+element.image;
      }
      images += `
      <div class="hotelImgaesPreviewRow d-flex flex-wrap mt-4"  id="otherimagessection${i}">
        <div class="hotelImgaesPreviewCol">
          <img src="{{asset('/assets/images/')}}/structure/delete-circle-red.svg" alt="" class="deteteImageIcon"
            onclick="removeImage(${i})"
          >
          <i
            class="fa fa-star favStar ${element.isFeatured === 1 ? 'favStar-fill': 'favStar-outline'}"
            aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true"
            onclick="markUnmark(${i}, ${element.isFeatured === 1? 0: 1})"
            title="<div class='tooltipbox centerArrowTT'>
            <small class='mediumfont'>${element.isFeatured === 1 ? 'Unmark as Featured': 'Mark as Featured'}</small> </div>">
          </i>
          <img src="${image}" alt="" class="hotelPreviewImgae">
        </div>
      </div>`;
      i++;
    });
    $('#otherImagePreview').html(images);
  }

  function getOtherImage() {
    let otherimage = $('#otherimageP').val();
    let otherimages = otherimage !== '' ? JSON.parse($('#otherimageP').val()) : [];
    showOtherImages(otherimages);
  }
  getOtherImage();

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
        let otherimage = $('#otherimageP').val();
        let otherimages = otherimage !== '' ? JSON.parse($('#otherimageP').val()) : [];
        var base64data = reader.result;
        otherimages.push({
          'image': base64data,
          'type': 'base64',
          'isFeatured': otherimages.length > 0 ? '0': '1'
        })
        showOtherImages(otherimages);
        $('#otherimageP').val(JSON.stringify(otherimages));
        unloading();
        $modal.modal('hide');
      }
    });
  });
  $(document).ready(function(){

    @if (isset($post))
      @if ($post->type == 'events')
        $('#event').click();
      @else
        $('#magazine').click();
      @endif
    @endif

    @if (isset($post))
      @switch($post->status)
        @case('draft')
          $('#draft').click();
          @break
        @case('active')
          $('#active').click();
          @break
        @case('inactive')
          $('#inactive').click();
          @break
        @default
          $('#draft').click();
      @endswitch
    @else
      $('#draft').click();
    @endif
    
    $('#post_input').submit(function(e){
      $('#thumbimage_err_msg').html('');
      $('#post_title_err_msg').html('');
      $('#PostType_err_msg').html('');
      $('#post_content_err_msg').html('');
      let isvalid = true;
      if ($('#thumbimage').val() === '') {
        isvalid = false;
        $('#thumbimage_err_msg').html('Please upload thumbnail image');
      }
      if ($('#otherimageP').val() === '') {
        isvalid = false;
      }
      if ($('#post_title').val() === '') {
        isvalid = false;
        $('#post_title_err_msg').html('Please enter post title');
      }
      if (!$('.PostType').is(":checked")) {
        isvalid = false;
        $('#PostType_err_msg').html('Please select post type');
      }
      let postType = '';
      $('.PostType').each(function(){
        if ($(this).is(":checked")) {
          postType = $(this).val();
        }
      });
      if (postType === 'magazine') {
        if (CKEDITOR.instances.post_content.getData() === '') {
          isvalid = false;
          $('#post_content_err_msg').html('Please enter post Content');
        }
      }
      if (!isvalid) {
        e.preventDefault();
      }
    });
  });
</script>
@endsection
