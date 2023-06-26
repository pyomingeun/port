@php $i = 0; @endphp
@foreach ($rooms as $room)
<div
  class="chatdtlrow d-flex {{ $i === 0?'active':'' }}"
  id="room-{{ $room->id }}"
  data-roomid="{{ $room->id }}"
  style="cursor: pointer;"
>
  <div class="ctr-img-box">
    <img src="{{
        auth()->user()->access === 'customer'?
        $room->getFriend->profile_pic:
        $room->getUser->profile_pic
      }}" class="ctr-img" alt="Profile"
      onerror="this.onerror=null;this.src='{{ asset("assets/images/structure/hotel_default.png")}}';" />
  </div>
  <div class="ctrMsgDtl">
    <h6 class="mb-1">{{
      auth()->user()->access === 'customer'?
      $room->getFriend->full_name:
      $room->getUser->full_name
    }} <span class="chattmLft">{{ $room->getLastMessage->created_at->diffForHumans() }}</span></h6>
    <p class="p3" id="chat-room-{{ $room->id }}">{{ $room->getLastMessage->message }}</p>
  </div>
</div>
@php $i++; @endphp
@endforeach