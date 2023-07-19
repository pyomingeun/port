<div class="profile-progress-box d-flex align-items-center move-left" style="width: 300px;"">
    <div class="progressbar">
        <div class="second circle" data-percent="{{$hotel->completed_percentage}}">
            <strong></strong>
        </div>
    </div>
    <div class="prog-des">
        <h6 class="p3">{{ __('home.Completeyourprofile') }}</h6>

    </div>
</div>

<style>
.move-left {
    margin-right: 150px; /* Adjust the value as per your desired spacing */
}
</style>
