@extends('frontend.layout.head')
@section('body-content')
@if(auth()->user()->access == 'customer')
    @include('customer.header')        
@else
    @include('hotel.header')
@endif

    <div class="main-wrapper-gray">
        @if(auth()->user()->access == 'customer')
            @include('customer.leftbar')        
        @else
            @include('hotel.leftbar')
        @endif
        <div class="content-box-right profile-sec">
            <div class="container-fluid">
                @foreach($list as $row)
                <div class="notification-msg-rw d-flex flex-wrap align-items-center mb-3">
                    <div class="ntIconBox">
                        <img src="{{asset('/assets/images/')}}/structure/notification-circle.svg" alt="">
                        @if($row->read == '0')
                        <span class="status-dot"></span>
                        @endif
                    </div>
                    <p class="p2 mb-0">{{ $row->message }}</p>
                    <!-- <p class="p2 mb-0">Your booking <span>[Booking Reference - 1011]</span> completed with Radisson Blue.</p> -->
                    <p class="p3 mb-0 ml-auto">{{ date_format($row->created_at,"Y-m-d") }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
    $(document).ready(function(){
        $(document).on('click','.sortdata',function(){
            // console.log('sort');
            var o = $(this).attr('data-o');
            // var i = $(this).attr('data-i');
            var c = $(this).attr('data-c');
            //  console.log(o+" "+c);
            var url = "{{ route('rooms') }}"; 
            url = url+'?o='+o+'&c='+c;//+'&i='+i;    
            window.location.href = url;
        });
        // delete account 
        $(document).on('click','.delRoom',function(){
                var i = $(this).attr('data-i');
                $("#roomDelYes").attr('data-i',i);                
        });            
        $(document).on('click','#roomDelYes',function(){
            var i = $(this).attr('data-i');
            var url = "{{ route('room_status',['slug'=>':i','status'=>'deleted'])}}";  
            url = url.replace(':i', i);
            // alert(url);
            window.location.href = url;
        });
    });
</script>
@endsection
