<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 26/05/2018
 * Time: 11:43
 */

namespace CodeFlix\PayPal;


use CodeFlix\Events\PayPalPaymentApproved;
use CodeFlix\Models\Plan;

class PaymentClient
{

    public function doPayment(Plan $plan)
    {
        //fazer o pagamento com o paypal
        $event = new PayPalPaymentApproved($plan);
        event($event);
        return $event->getOrder();
        //fazer o cadastro da order
    }
}