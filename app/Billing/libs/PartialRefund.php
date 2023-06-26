<?php

header("Content-Type: text/html; charset=utf-8");

    //step1. Set parameters for request

    $key             = "ItEQKi3rY7uvDS8l";
    $type            = "PartialRefund";
    $paymethod       = "Card";
    $timestamp       = date("YmdHis");
    $clientIp        = "192.0.0.1";
    $mid             = "INIpayTest";
    $tid             = "";
	$price           = "500";
	$confirmPrice    = "500";
	$msg             = "테스트";

	// INIAPIKey + type + paymethod + timestamp + clientIp + mid + tid + price + confirmPrice
    $hashData = hash("sha512",(string)$key.(string)$type.(string)$paymethod.(string)$timestamp.(string)$clientIp.(string)$mid.(string)$tid.(string)$price.(string)$confirmPrice); // hash 암호화


    //step2. post request with key=value
    $data = array(
        'type' => $type,
        'paymethod' => $paymethod,
        'timestamp' => $timestamp,
        'clientIp' => $clientIp,
        'mid' => $mid,
        'tid' => $tid,
        'price' => $price,
		    'confirmPrice' => $confirmPrice,
	    	'msg' => $msg,
        'hashData'=> $hashData
	);

    $url = "https://iniapi.inicis.com/api/v1/refund";

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

    //step3. result of partial refunt request
	echo $response;

?>
