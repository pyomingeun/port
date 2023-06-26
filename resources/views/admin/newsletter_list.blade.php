@extends('frontend.layout.head')
@section('body-content')

@include('hotel.header')
<!-- include left bar here -->

    <div class="main-wrapper-gray">
        @include('admin.leftbar')
        <div class="content-box-right earnings-payouts-sec">
            <div class="container-fluid">
                <h5 class="h5  mb-3">News-Letter Management</h5>
                <div class="heading-sec mb-4 d-flex align-items-center">
                    
                    <form action="" method="get" id="nl_lsiting">
                    <div class="filter-header-row ml-auto d-flex justify-content-end">
                        <div class="filter-header-col searchFilBox ms-0">
                            <img src="{{asset('/assets/images/')}}/structure/search-gray.svg" alt="" class="searchIcon" />
                            <input type="text" class="form-control onenter_sumbit_hml" placeholder="Search"  name="q" value="{{ (isset($q))?$q:''; }}"/>
                        </div>
                        
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                         <a  href="{{ route('newsletter-list') }}"><img src="{{asset('/assets/images/')}}/structure/reset_img.png" alt="" class="reset-img cursor-p" id="picDelcross" style="display:block"></a>
                        </div> 
                        <input type="hidden" name="c" value="{{ (isset($c))?$c:''; }}">
                        <input type="hidden" name="o" value="{{ (isset($o))?$o:''; }}">
                        <div class="filter-header-col filter-dd-wt-sd-lable">
                            <button type="button" class="btn h-36" id="export_csv">{{ __('home.ExportCSV') }} </button>
                        </div>        
                    </div>
                    </form>
                </div>

                <!-- <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
                        <img src="{{asset('/assets/images/')}}/structure/earning-payout-empty-img.png" alt="" class="empty-list-image">
                        <h6>Your earnings & payouts list is empty</h6>
                        <p class="p3">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                    </div>
                </div> -->
                <div class="tableboxpadding0">
                    <div class="table-responsive table-view tableciew1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <p>
                                            Email 
                                            <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='email' && $o=='desc')?'hidesorticon':''; }}" data-c="email" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='email' && $o=='asc')?'hidesorticon':''; }}" data-c="email" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>                                    
                                    <th>
                                        <p>
                                           Subscribed On
                                           <span class="sort-arrow-table">
                                                <i class="fa fa-caret-up arrow-up sortdata {{ ($c=='created_at' && $o=='desc')?'hidesorticon':''; }}" data-c="created_at" data-o="asc"></i>
                                                <i class="fa fa-caret-up arrow-down sortdata {{ ($c=='created_at' && $o=='asc')?'hidesorticon':''; }}" data-c="created_at" data-o="desc"></i>
                                            </span>
                                        </p>
                                    </th>
                                    <!-- <th>
                                        <p>
                                            Action
                                        </p>
                                    </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $row)
                                <tr>
                                    <td>{{ $row->email; }}</td>
                                    <td>{{ date_format($row->created_at,"Y-m-d") }}</td>
                                    @php
                                    /*
                                    @endphp
                                    <td class="actionDropdown ">
                                        <button class="dropdown-toggle actiob-dd-Btn" data-bs-toggle="dropdown">
                                            <img src="{{asset('/assets/images/')}}/structure/dots.svg" alt="" class="actiob-dd-Icon">
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li> 
                                                <a class="dropdown-item delUser" href="" data-i="{{ $row->id }}" data-bs-toggle="modal" data-bs-target=".deleteDialog"><img src="{{asset('/assets/images/')}}/structure/trash-20.svg" alt="" class="deleteIcon"> Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                    @php
                                    */
                                    @endphp
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$list->appends(Request::only(['search']))->links('pagination::bootstrap-4')}}
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
                        <h3 class="h3 mt-2">Delete Subscriber</h3>
                        <p class="p2 mb-4">Are you sure you want to delete this Subscriber?</p>
                    </div>
                    <div class="d-flex btns-rw">
                        <button class="btn bg-gray flex-fill" id="userDelYes" data-i="0">Yes</button>
                        <button class="btn flex-fill" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<style>
    .daterangepicker.dropdown-menu.ltr.show-calendar.opensright {
        left: auto !important;
        right: 0 !important;
    }
</style>

@include('frontend.layout.footer_script')
@endsection

    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function(){

            $(document).on('keyup','.onenter_sumbit_hml',function(e){
                console.log(e.keyCode);
                if(e.keyCode == 13)
                     $( "#nl_lsiting" ).submit();
            });

            $(document).on('click','.sortdata',function(){
                // console.log('sort');
                var o = $(this).attr('data-o');
                // var i = $(this).attr('data-i');
                var c = $(this).attr('data-c');
                //  console.log(o+" "+c);
                var url = "{{ route('newsletter-list') }}"; 
                url = url+'?o='+o+'&c='+c;//+'&i='+i;    
                window.location.href = url;
                
            });

            // delete Facilitie 
            $(document).on('click','.delUser',function(){
                var i = $(this).attr('data-i');
                $("#userDelYes").attr('data-i',i);                
            });            
            $(document).on('click','#userDelYes',function(){
                var i = $(this).attr('data-i');
                var url = "{{ route('newsletter-status',['id'=>':i','status'=>'deleted'])}}";  
                url = url.replace(':i', i);
                window.location.href = url;
            });
            

        $(document).on('click','#export_csv',function(){
            let rows = <?php echo json_encode($exportRows); ?>; 
            let filename = <?php echo json_encode($filename); ?>; 
           exportToCsv(filename, rows);
        }); 
        function exportToCsv(filename, rows) { var processRow = function (row) { var finalVal = ''; for (var j = 0; j < row.length; j++) { var innerValue = row[j] === null ? '' : row[j].toString(); if (row[j] instanceof Date) { innerValue = row[j].toLocaleString(); }; var result = innerValue.replace(/"/g, '""'); if (result.search(/("|,|\n)/g) >= 0) result = '"' + result + '"'; if (j > 0) finalVal += ','; finalVal += result; } return finalVal + '\n'; }; var csvFile = ''; for (var i = 0; i < rows.length; i++) { csvFile += processRow(rows[i]); } var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' }); __export(blob, filename + ".csv"); }
        function __export(blob, filename) {
            console.log(filename);
            if (navigator.msSaveBlob) { navigator.msSaveBlob(blob, filename); } else { var link = document.createElement("a"); if (link.download !== undefined) { var url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); } }
            }
        });

    </script>   
    @endsection