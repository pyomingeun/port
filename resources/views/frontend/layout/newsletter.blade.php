<section class="subscribeNewsletter-section">
        <div class="container">
            <div class="subscribeNewsletterBox">
                <h2 class="Subscribe Our Newsletter">{{ __('home.subscribe') }} <br> {{ __('home.OurNewsletter') }}</h2>
                <form action="javaScript:void(0);" method="post" id="subscribe_form">
                <div class="subscribeNewsletterForm" id="subscribe_email_validate">
                    <input type="text" placeholder="{{ __('home.enterEmail') }}" id="subscribe_email" name="subscribe_email">
                    <button type="button" class="btn h-36" id="subscribe_submit">{{ __('home.subscribe') }}</button>
                    <p class="error-inp" id="subscribe_email_err_msg"></p>
                    <p class="error-inp" id="subscribe_server_err_msg"></p>
                    <p class="success-inp" id="subscribe_server_success_msg"></p>
                </div>
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                <img src="{{asset('/assets/images/structure/subscribe-bg-img.png')}}" class="subscribe-bg-img"> 
                </form>
            </div>
        </div>
    </section>