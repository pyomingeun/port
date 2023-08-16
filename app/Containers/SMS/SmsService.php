<?php

namespace App\Containers\SMS;

class SmsService
{
    private $api_server;
    private $service_id;
    private $access_key_id;
    private $secret_key;
    private $sender;

    public function __construct($url, $access_key_id, $secret_key, $sender, $service_id)
    {
        $this->api_server = $url;
        $this->service_id = $service_id;
        $this->access_key_id = $access_key_id;
        $this->secret_key = $secret_key;
        $this->sender = $sender;
    }

    public function send($to, $message)
    {
        //전송할 핸드폰 번호를 여기에 넣는다
        $phoneNum = $to;

        $sID = $this->service_id;

        $smsURL = $this->api_server."/sms/v2/services/".$sID."/messages";
        $smsUri = "/sms/v2/services/".$sID."/messages";

        $accKeyId = $this->access_key_id;   //인증키 id
        $accSecKey = $this->secret_key;     //secret key

        $sTime = floor(microtime(true) * 1000);

        // The data to send to the API
        $postData = array(
            'type' => 'SMS',
            'countryCode' => '82',
            'subject' => "문자제목인가?",
            'from' => $this->sender,    //발신번호 (등록되어있어야함)
            'contentType' => 'COMM',
            'content' => "메세지 내용",  //안보임.
            'messages' => array(array('content' => $message, 'to' => $phoneNum))
        );

        $postFields = json_encode($postData) ;

        $hashString = "POST {$smsUri}\n{$sTime}\n{$accKeyId}";


        $dHash = base64_encode( hash_hmac('sha256', $hashString, $accSecKey, true) );

        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'x-ncp-apigw-timestamp: '.$sTime,
            "x-ncp-iam-access-key: ".$accKeyId,
            "x-ncp-apigw-signature-v2: ".$dHash
        );

        $ch = curl_init($smsURL);

        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $postFields
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}