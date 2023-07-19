<!doctype html>
<html lang="ko">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('/assets/images/logo/favicon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css" />
  <link href="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/assets/scss/custom.css') }}" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/assets/scss/style.css') }}" />

  <script>
    function gres(params) {
      return;
    }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=ko&callback=gres"></script>

  <style>
    .no-display {
      display: none !important;
    }
  </style>

  <title>Traveledge</title>
</head>

<body>

  @yield('body-content')
  <!-- msg alearts -->
  <div class="alertDialog" id="commonErrorBox" style="display:none;">
    <p class="mb-0 alertmsinner-box alertDanger">
      <img src="{{ asset('/assets/images/') }}/structure/warning.svg" class="alertIcn"><span id="commonErrorMsg"></span>
    </p>
  </div>
  <div class="alertDialog" id="commonSuccessBox" style="display:none;">
    <p class="mb-0 alertmsinner-box alertSuccess"><img
        src="{{ asset('/assets/images/') }}/structure/check-circle-green.svg" class="alertIcn"><span
        id="commonSuccessMsg"></span>
    </p>
  </div>
  @yield('js-script')
</body>

</html>
