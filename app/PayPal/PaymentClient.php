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
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaymentClient
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * PaymentClient constructor.
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    public function get($paymentId)
    {
        return Payment::get($paymentId, $this->apiContext);
    }

    /**
     * Finalizar o pagamento
     * @param Plan $plan
     * @return mixed
     */
    public function doPayment(Plan $plan, $paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($plan->value);

        $amount = new Amount();
        $amount->setCurrency('BRL')
            ->setTotal($plan->value)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $payment->execute($execution, $this->apiContext);

        //fazer o pagamento com o paypal
        $event = new PayPalPaymentApproved($plan, $payment);
        event($event);
        return $event->getOrder();
        //fazer o cadastro da order
    }

    //gera link de pagamento
    public function makePayment(Plan $plan)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $duration = $plan->duration == Plan::DURATION_MONTHLY ? 'Mensal' : 'Anual';
        $item = new Item();
        $item->setName("Plano $duration")
            ->setSku($plan->sku)
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setPrice($plan->value);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($plan->value);

        $amount = new Amount();
        $amount->setCurrency('BRL')
            ->setTotal($plan->value)
            ->setDetails($details);

        $payee = new Payee();
        $payee->setEmail(env('PAYPAL_PAYEE_EMAIL'));

        $transaction = new Transaction();
        $transaction
            ->setItemList($itemList)
            ->setAmount($amount)
            ->setDescription("Pagamento do plano de assinatura")
            ->setPayee($payee)
            ->setInvoiceNumber(uniqid());

        $baseUrl = url('/');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/payment/success")
            ->setCancelUrl("$baseUrl/payment/cancel");

        $payment = new Payment();
        $payment->setExperienceProfileId($plan->webProfile->code)
            ->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try{
            $payment->create($this->apiContext);
        } catch (PayPalConnectionException $exception){
            \Log::error($exception->getMessage(), ['data' => $exception->getData()]);
            throw $exception;
        }

        //dd($payment);

        return $payment;
    }

    //0 - Pegar link de aprovação
    //1 - Informações do cartão
    //2 - Paypal autoriza o pagamento
    //3 - Enviar pra API - finalizar o pagamento
}