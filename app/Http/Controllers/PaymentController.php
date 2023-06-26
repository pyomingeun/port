<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billing\PaymentGateway;

class PaymentController extends Controller
{
    public function store(PaymentGateway $paymentGateway)
    {
        $amount = 1000;
        $order_id = 124;
        $signData = $paymentGateway->createSignature($amount, $order_id);

        $paymentData = (object)[
            'signData' => $signData,
            'method' => 'card',
            'goodname' => 'bookings',
            'buyername' => 'test',
            'buyertel' => '01012345678',
            'buyeremail' => 'test@test.com'
        ];
        // dd($paymentData);
        return view('payment.payment', compact('paymentData'));
    }

    public function return(PaymentGateway $paymentGateway, Request $request, $order_id)
    {
        $response = $paymentGateway->validateReturn($request->all());
        dd($order_id, $response);
    }

    public function cancel(PaymentGateway $paymentGateway, Request $request, $order_id)
    {
        return view('payment.failed', compact('order_id'));
    }

    public function refundPayment(PaymentGateway $paymentGateway)
    {

        // for full refund
        /**
         * @param string $type
         * $type = 'Refund' for full refund
         * @param string $payMethod
         * $payMethod = 'Card' for card payment
         */
        $fullpayment = $paymentGateway->refundPayment('Refund', 'Card'); 
        // for partial refund
        /**
         * @param string $type
         * $type = 'PartialRefund' for partial refund
         * @param string $payMethod
         * $payMethod = 'Card' for card payment
         * @param int $amount
         * $price = amount to be refunded
         * @param int $confirmPrice
         * $confirmPrice = amount to be refunded
         */
        $partialPayment = $paymentGateway->refundPayment('PartialRefund', 'Card', 1000, 1000);
        dd($fullpayment, $partialPayment);
    }
}
