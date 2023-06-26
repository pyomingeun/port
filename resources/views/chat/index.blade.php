@extends('frontend.layout.head')
@section('body-content')
@include('customer.header')
<!-- include left bar here -->
@include('customer.leftbar')    

<div class="content-box-right chat-sec">
  <div class="container-fluid">
    @if (count($rooms) > 0)
    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-4 col-md-12 col-sm-4 col-12 chat-left-sidebar">
        <div class="chat-search-box">
          <input type="text" placeholder="Search" class="chatSearchInp" id="search" />
          <img src="{{ asset('assets/images/structure/search.svg') }}" class="searchIcon" alt="" />
        </div>
        <div class="chat-left-content-box" id="roomlist">
          {{ view('chat.roomlist', ['rooms' => $rooms]) }}
        </div>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-md-12 col-sm-8 col-12 chat-content-main-box">
        @if (count($chatMessages) > 0)  
        <div class="chatboard-box">
          <div class="chatboard w-100" id="chatboard">
            @foreach ($chatMessages as $chatMessage)    
            <div class="{{ $chatMessage->receiver_id === auth()->user()->id?'msgboxReply':'msgboxSent' }}">
              <div class="msgmainrw">
                <div class="{{ $chatMessage->receiver_id === auth()->user()->id?'mgsReply':'mgsSent' }}">
                  {{ $chatMessage->message }}
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="chatboxftr">
            <input type="hidden" id="room-id" value="{{ $chatMessage->chat_room_id }}"/>
            <input type="hidden" id="receiver-id" value="{{
              auth()->user()->id !== $chatMessage->sender_id ?
                $chatMessage->sender_id:
                $chatMessage->receiver_id
            }}"/>
            <input type="hidden" id="sender-id" value="{{ auth()->user()->id }}"/>
            <input type="text" placeholder="Write here..." id="sendMessage" class="chatinput" />
            <img src="{{ asset('assets/images/structure/send.svg')}}" class="sendBtn" />
          </div>
        </div>
        @endif
      </div>
    </div>
    @else
    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-9 col-sm-12 col-12 mx-auto empty-list-box text-center">
        <img src="{{asset('/assets/images/')}}/structure/chat-empty-image.png" alt="" class="empty-list-image"/>
        <h6>No chat available</h6>
      </div>
    </div>
    @endif
  </div>
</div>

<!-- common models -->
@include('common_models')
@include('frontend.layout.footer_script')
@endsection
<!-- JS section  -->   
@section('js-script')
<script>
  $(document).ready(function() {

    function getAllChats (roomId) {
      const url = "{{ route('chat.getMessages') }}?roomId=" + roomId;
      $.ajax({
        url: url,
        type: 'GET',
        data: {},
        success: function(response) {
          if (response.status == 'success') {
            $('#chatboard').html('');
            $('#room-id').val(roomId);
            $('#receiver-id').val(response.data[0].receiver_id);
            response.data.forEach(element => {
              $('#chatboard').append(
                '<div class="' + (element.receiver_id === {{ auth()->user()->id }} ? 'msgboxReply' : 'msgboxSent') + '"><div class="msgmainrw"><div class="' + (element.receiver_id === {{ auth()->user()->id }} ? 'mgsReply' : 'mgsSent') + '">' +
                element.message + '</div></div></div>');
            });
            $('#chatCount').text(response.chatCount);
            getChatBoxToBottom();
          }
        }
      });
    }

    $('#sendMessage').keyup(function(e) {
      if (e.keyCode == 13 && $(this).val().trim() != '') {
        const message = $(this).val();
        const roomId = $('#room-id').val();
        const receiverId = $('#receiver-id').val();
        const senderId = $('#sender-id').val();
        const url = "{{ route('chat.store') }}";
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            message: message,
            roomId: roomId,
            receiverId: receiverId,
            senderId: senderId,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            if (response.status == 'success') {
              $('#chatboard').append(
                '<div class="msgboxSent"><div class="msgmainrw"><div class="mgsSent">' +
                message + '</div></div></div>');
							$('#chat-room-'+ roomId).text(message);
              $('#sendMessage').val('');
              getChatBoxToBottom();
            }
          }
        });
      }
    });

    $('.chatdtlrow').click(function() {
      $('.chatdtlrow').removeClass('active');
      $(this).addClass('active');
      const roomId = $(this).attr('data-roomid');
      getAllChats (roomId)
    });

    $('#search').keyup(function() {
      const search = $(this).val();
      const url = "{{ route('chat.search') }}";
      $.ajax({
        url: url,
        type: 'GET',
        data: {search: search},
        success: function(response) {
          if (response.status == 'success') {
            $('#roomlist').html(response.data);
            getAllChats (response.roomid)
            $('.chatdtlrow').click(function() {
              $('.chatdtlrow').removeClass('active');
              $(this).addClass('active');
              const roomId = $(this).attr('data-roomid');
              getAllChats (roomId)
            });
          }
        }
      });
    });

    function getChatBoxToBottom () {
      var chatboard = document.getElementById('chatboard');
      chatboard.scrollTop = chatboard.scrollHeight;
    }

    getChatBoxToBottom();

    @if (count($rooms) > 0)
    getAllChats ({{ $rooms[0]->id }})
    @endif

  });
</script>
@endsection