<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!--테스트 JS-->
  <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js"
    charset="UTF-8"></script>
  <!--운영 JS> <script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8">
  </script> -->
</head>

<body>
  <form id="SendPayForm_id">
    <input type="hidden" name="version" value="{{ $paymentData->signData->version }}">
    <input type="hidden" name="gopaymethod" value="{{ $paymentData->method }}">
    <input type="hidden" name="mid" value="{{ $paymentData->signData->mid }}">
    <input type="hidden" name="oid" value="{{ $paymentData->signData->oid }}">
    <input type="hidden" name="price" value="{{ $paymentData->signData->price }}">
    <input type="hidden" name="timestamp" value="{{ $paymentData->signData->timestamp }}">
    <input type="hidden" name="signature" value="{{ $paymentData->signData->signature }}">
    <input type="hidden" name="mKey" value="{{ $paymentData->signData->mKey }}">
    <input type="hidden" name="currency" value="{{ $paymentData->signData->currency }}">
    <input type="hidden" name="goodname" value="{{ $paymentData->goodname }}">
    <input type="hidden" name="buyername" value="{{ $paymentData->buyername }}">
    <input type="hidden" name="buyertel" value="{{ $paymentData->buyertel }}">
    <input type="hidden" name="buyeremail" value="{{ $paymentData->buyeremail }}">
    <input type="hidden" name="returnUrl" value="{{ $paymentData->signData->returnUrl }}">
    <input type="hidden" name="closeUrl" value="{{ $paymentData->signData->cancelUrl }}">
    <input type="hidden" name="acceptmethod" value="{{ $paymentData->signData->acceptmethod }}">
    <button type="button" onclick="paybtn()">Pay</button>
  </form>

  <script type="text/javascript">
    function paybtn() {
      INIStdPay.pay('SendPayForm_id');
    }
  </script>
</body>

</html>
