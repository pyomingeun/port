<?php

namespace App\Billing;

use App\Billing\libs\INIStdPayUtil;
use App\Billing\libs\HttpClient;

class PaymentGateway
{
  private $currency;
  private $environment;
  private $mid;
  private $signKey;
  private $returnUrl;
  private $cancelUrl;
  private $version;

  public function __construct($currency, $environment, $mid, $signKey, $returnUrl, $cancelUrl, $version)
  {
    $this->currency = $currency;
    $this->environment = $environment;
    $this->mid = $mid;
    $this->signKey = $signKey;
    $this->returnUrl = $returnUrl;
    $this->cancelUrl = $cancelUrl;
    $this->version = $version;
  }

  public function createSignature($amount, $order_id)
  {
    $SignatureUtil = new INIStdPayUtil();
    $mKey = $SignatureUtil->makeHash($this->signKey, "sha256");
    if ($this->environment == "test") {
      $timestamp = $SignatureUtil->getTimestamp();
      $orderNumber = 'DemoTest_1665015978819';
      $price = 1000;
    } else {
      $timestamp = $SignatureUtil->getTimestamp();
      $orderNumber = $this->mid . "_" . $timestamp;
      $price = $amount;
    }
    $params = array(
      "oid" => $orderNumber,
      "price" => $price,
      "timestamp" => $timestamp
    );
    $sign = $SignatureUtil->makeSignature($params);
    return (object)[
      'mid' => $this->mid,
      'signature' => $sign,
      'mKey' => $mKey,
      'oid' => $orderNumber,
      'price' => $price,
      'timestamp' => $timestamp,
      'acceptmethod' => 'va_receipt',
      'currency' => $this->currency,
      'returnUrl' => $this->returnUrl . '/' . $order_id,
      'cancelUrl' => $this->cancelUrl . '/' . $order_id,
      'version' => $this->version
    ];
  }

  public function validateReturn($request)
  {
    $util = new INIStdPayUtil();
    $httpUtil = new HttpClient();

    try {
      if (strcmp("0000", $request->resultCode) == 0) {
        
        $timestamp  = $util->getTimestamp();
        $charset    = "UTF-8";
        $format     = "JSON";
        $authToken  = $request->authToken; 
        $netCancel  = $request->netCancelUrl;        
        $merchantData = $request->merchantData;
        $signParam["authToken"] = $authToken;
        $signParam["timestamp"] = $timestamp;
        $signature = $util->makeSignature($signParam);
        $authMap["mid"]        = $request->mid;
        $authMap["authToken"]  = $authToken;
        $authMap["signature"]  = $signature;
        $authMap["timestamp"]  = $timestamp;
        $authMap["charset"]    = $charset;
        $authMap["format"]     = $format;
        try {
          $authResultString = "";
          if ($httpUtil->processHTTP($request->authUrl, $authMap)) {
              $authResultString = $httpUtil->body;
          } else {
            return (object)[
              'status' => 'fail',
              'message' => $$httpUtil->errormsg
            ];
          }
          $resultMap = json_decode($authResultString, true);
          return (object)[
            'status' => 'success',
            'result' => $resultMap
          ];
        } catch (\Exception $e) {
          return (object)[
            'status' => 'fail',
            'message' => $e->getMessage()
          ];
        }
      } else {
        return (object)[
          'status' => 'fail',
          'message' => '결제 실패'
        ];
      }
    } catch (\Exception $e) {
      return (object)[
        'status' => 'fail',
        'message' => $e->getMessage()
      ];
    }
  }

  public function refundPayment(
    $type = "Refund",
    $paymethod = "Card",
    $price = "0",
    $confirmPrice = "0"
  )
  {
    // $type  = "Refund || PartialRefund";
    $key         = "ItEQKi3rY7uvDS8l";
    $timestamp   = date("YmdHis");
    $clientIp    = "192.0.0.1";
    $mid         = $this->mid;
    $tid         = "";
	  $msg         = "테스트";

    $hashData = hash("sha512",(string)$key.(string)$type.(string)$paymethod.(string)$timestamp.(string)$clientIp.(string)$mid.(string)$tid);
    if ($type == "PartialRefund") {
      $hashData = hash("sha512",(string)$key.(string)$type.(string)$paymethod.(string)$timestamp.(string)$clientIp.(string)$mid.(string)$tid.(string)$price.(string)$confirmPrice);
    }
    $data = array(
      'type' => $type,
      'paymethod' => $paymethod,
      'timestamp' => $timestamp,
      'clientIp' => $clientIp,
      'mid' => $mid,
      'tid' => $tid,
      'msg' => $msg,
      'hashData'=> $hashData
    );
    if ($type == "PartialRefund") {
      $data['price'] = $price;
      $data['confirmPrice'] = $confirmPrice;
    }
    $url = env('INI_REFUND_URL', 'https://iniapi.inicis.com/api/v1/refund');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8'));
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

}
