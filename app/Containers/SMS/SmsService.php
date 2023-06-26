<?php

namespace App\Containers\SMS;

class SmsService
{
    private $url;
    private $access_key_id;
    private $secret_key;
    private $sender;

    public function __construct($url, $access_key_id, $secret_key, $sender, $service_id)
    {
        $this->url = $url . '/sms/v2/services/' . $service_id . '/messages';
        $this->access_key_id = $access_key_id;
        $this->secret_key = $secret_key;
        $this->sender = $sender;
    }

    public function send($to, $message)
    {
        // Send the message
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        // set headers
        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        $headers[] = 'x-ncp-apigw-timestamp: ' . strval(time() * 1000);
        $headers[] = 'x-ncp-iam-access-key: ' . $this->access_key_id;
        $headers[] = 'x-ncp-apigw-signature-v2: ' . $this->secret_key;
        // check curl headers
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // set body
        $body = array(
            'type' => 'SMS',
            'contentType' => 'COMM',
            'from' => $this->sender,
            'content' => $message,
            'messages' => array(
                array(
                    'to' => $to
                )
            )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        $response = curl_exec($ch);
        // check error
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
}