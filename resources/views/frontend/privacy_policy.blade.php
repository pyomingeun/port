@extends('frontend.layout.head')
@section('body-content')
@include('frontend.layout.header')
    <section class="terms-conditions-sec1 top-banner-section">
        <div class="banner-image-dv d-flex align-items-center justify-content-center" style="background-image: url({{asset('/assets/images/')}}/structure/faq-bnr-img.png);">
            <div class="overlay"></div>
            <div class="bannerContent">
                <nav aria-label="breadcrumb" class="breadcrumbNave on-banner-breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> {{ __('home.home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{ __('home.PrivacyPolicy') }}</li>
                    </ol>
                </nav>
                <h5 class="h1 mb-0">{{ __('home.PrivacyPolicy') }}</h1>
            </div>
        </div>
    </section>
    <section class="terms-conditions-sec2 staticpagesContent">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-ld-12 col-md-12 col-sm-12 col-12">
                    <h5 class="h5">Lorem Ipsum is simply dummy text of the printing and typesetting industry?</h5>
                    <p class="p1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book. </p>
                    <p class="p1">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in
                        Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections
                        1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
                        "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    <p class="p1">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied
                        by English versions from the 1914 translation by H. Rackham.</p>
                    <p class="p1"></p>
                    <h5 class="h5">Lorem Ipsum is simply dummy text of the printing and typesetting industry?</h5>
                    <p class="p1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book. </p>
                    <p class="p1">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in
                        Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections
                        1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
                        "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    <p class="p1">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied
                        by English versions from the 1914 translation by H. Rackham.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. </p>
                    <p class="p1">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in
                        Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections
                        1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
                        "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    <p class="p1">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied
                        by English versions from the 1914 translation by H. Rackham.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- newsletter -->
    @include('frontend.layout.newsletter')
    <!-- footer -->
    @include('frontend.layout.footer')
    <!-- common models -->
    @include('common_models')
    @include('frontend.layout.footer_script')
    @endsection
    @section('page-js-include')
    @endsection
    <!-- JS section  -->   
    @section('js-script')
    <script>
        $(document).ready(function() {
            $(function() {
                $('.checjincheckout').daterangepicker({
                    locale: {
                        format: 'DD MMM,YYYY'
                    }
                });
            });
        });
    </script>
    @endsection