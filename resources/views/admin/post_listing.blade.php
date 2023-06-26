@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->
  <div class="main-wrapper-gray">
  	@include('admin.leftbar')
  	<div class="content-box-right earnings-payouts-sec">
      <div class="container-fluid">
      	<h5 class="h5  mb-3">Post Managment</h5>
      	<div class="heading-sec mb-4 d-flex align-items-center">
          <form action="" method="get" id="post_lsiting">
          	<div class="filter-header-row ml-auto d-flex justify-content-end">
              <div class="filter-header-col searchFilBox ms-0">
                <img src="{{asset('/assets/images/')}}/structure/search-gray.svg" alt="" class="searchIcon" />
                <input type="text" class="form-control onenter_sumbit_hml" placeholder="Search"  name="q" value="{{ (isset($_GET['q']))?$_GET['q']:''; }}"/>
              </div>
              <div class="filter-header-col filter-dd-wt-sd-lable">
                <div class="form-floating mb-0">
                  <span class="ddLAble monthLable">Status:</span>
                  <div class="">
                    <button type="button" id="child1" data-bs-toggle="dropdown" class="form-select">{{ (isset($_GET['status']) && $_GET['status']!='')?ucwords($_GET['status']):'All' }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li class="radiobox-image">
                        <input  class="filter_by_status" type="radio" id="payout1" name="status" value=""  {{ (isset($_GET['status']) && $_GET['status']=='')?'checked':'' }} />
                        <label for="payout1">All</label>
                      </li>
                      <li class="radiobox-image">
                        <input class="filter_by_status" type="radio" id="payout2" name="status" value="draft" {{ (isset($_GET['status']) && $_GET['status']=='draft')?'checked':'' }} />
                        <label for="payout2">Draft</label>
                      </li>
                      <li class="radiobox-image">
                        <input class="filter_by_status" type="radio" id="active" name="status" value="active" {{ (isset($_GET['status']) && $_GET['status']=='active')?'checked':'' }} />
                        <label for="active">Active</label>
                      </li>
                      <li class="radiobox-image">
                        <input class="filter_by_status" type="radio" id="inactive" name="status" value="inactive" {{ (isset($_GET['status']) && $_GET['status']=='inactive')?'checked':'' }} />
                        <label for="inactive">Inactive</label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="filter-header-col filter-dd-wt-sd-lable">
                <div class="form-floating mb-0">
                  <span class="ddLAble monthLable">Post Type:</span>
                  <div class="">
                    <button type="button" id="post1" data-bs-toggle="dropdown" class="form-select">{{ (isset($_GET['post']) && $_GET['post']!='')?ucwords($_GET['post']):'All' }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li class="radiobox-image">
                        <input  class="filter_by_post" type="radio" id="post1" name="post" value=""  {{ (isset($_GET['post']) && $_GET['post']=='')?'checked':'' }} />
                        <label for="post1">All</label>
                      </li>
                      <li class="radiobox-image">
                        <input class="filter_by_post" type="radio" id="post2" name="post" value="magazine" {{ (isset($_GET['post']) && $_GET['post']=='magazine')?'checked':'' }} />
                        <label for="post2">Magazine</label>
                      </li>
                      <li class="radiobox-image">
                        <input class="filter_by_post" type="radio" id="post3" name="post" value="events" {{ (isset($_GET['status']) && $_GET['status']=='events')?'checked':'' }} />
                        <label for="post3">Events</label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="filter-header-col filter-dd-wt-sd-lable">
               	<a  href="{{ route('admin-post-list') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
              </div>
							<div class="filter-header-col">
								<a href="{{ route('admin-post-create')}}" class="btn h-36">Create Post</a>
							</div>
          	</div>
          </form>
        </div>

        <div class="tableboxpadding0">
          <div class="table-responsive table-view tableciew1">
            <table class="table align-middle">
              {{-- <span class="sort-arrow-table">
                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='email' && $o=='desc')?'hidesorticon':''; }}" data-c="email" data-o="asc"></i>
                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='email' && $o=='asc')?'hidesorticon':''; }}" data-c="email" data-o="desc"></i>
              </span> --}}
              <thead>
                <tr>
                  <th><p>Image</p></th>
                  <th><p>Title</p></th>
                  <th><p>Post Type</p></th>
                  <th><p>Status</p></th>
                  <th><p>Action</p></th>
                </tr>
              </thead>
              <tbody>
								@forelse ($posts as $post)
                <tr>
                  <td><img src="{{ asset($post->image) }}" alt="{{ $post->image }}" style="max-width: 100px"></td>
                  <td class="text-capitalize">{{ $post->title }}</td>
                  <td class="text-capitalize">{{ $post->type }}</td>
                  <td class="text-capitalize">{{ $post->status }}</td>
									<td class="actionDropdown">
                    <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
											<img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li>
                        <a class="dropdown-item" href="{{route('admin-post-edit',$post->id)}}">
                          <img src="{{asset('/assets/images/')}}/structure/edit.svg" alt="" class="editIcon">
                          Edit
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{route('reward-details',$post->id)}}">
                          <img src="{{asset('/assets/images/')}}/structure/eye-icon.svg" alt="" class="editIcon">
                          View
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item delPost" href="" data-i="{{ $post->id }}" data-bs-toggle="modal" data-bs-target=".deleteDialog">
                          <img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon">
                          Delete
                        </a>
                      </li>
                    </ul>
                  </td>
                </tr>
								@empty
								<tr><td colspan="4" class="text-center">No data found</td></tr>
								@endforelse
              </tbody>
            </table>
          </div>
        </div>
        {{$posts->appends(Request::only(['search']))->links('pagination::bootstrap-4')}}
      </div>
    </div>
	</div>

  <div class="modal fade deleteDialog" tabindex="-1" aria-labelledby="DeleteDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-heads">
            <h3 class="h3 mt-2">Delete Post</h3>
            <p class="p2 mb-4">Are you sure you want to delete this Post?</p>
          </div>
          <div class="d-flex btns-rw">
            <form action="{{ route('admin-post-destroy') }}" method="post">
              @csrf
              <input type="hidden" name="post_id" id="postDelYes">
              <button type="submit" class="btn bg-gray flex-fill" id="" data-i="0">Yes</button>
              <button type="button" class="btn flex-fill" data-bs-dismiss="modal">No</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>  
@include('common_models')
@include('frontend.layout.footer_script')

@endsection

@section('js-script')
<script>
  $(document).ready(function(){
    $('.delPost').click(function(){
      var id = $(this).data('i');
      $('#postDelYes').val(id);
    });
    $('.filter_by_status').change(function(){
      $('#post_lsiting').submit();
    });
    $('.filter_by_post').change(function(){
      $('#post_lsiting').submit();
    });
  });
</script>
@endsection