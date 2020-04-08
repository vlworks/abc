<?php


namespace Facade;


use Service\Billing\BillingInterface;
use Service\Billing\Exception\BillingException;
use Service\Communication\CommunicationInterface;
use Service\Communication\Exception\CommunicationException;
use Service\Discount\DiscountInterface;
use Service\User\SecurityInterface;

class CheckoutProcess
{
    private $discount;
    private $billing;
    private $security;
    private $communication;

    /**
     * CheckoutProcess constructor.
     * @param $discount
     * @param $billing
     * @param $security
     * @param $communication
     */
    public function __construct(
        DiscountInterface $discount,
        BillingInterface $billing,
        SecurityInterface $security,
        CommunicationInterface $communication)
    {
        $this->discount = $discount;
        $this->billing = $billing;
        $this->security = $security;
        $this->communication = $communication;
    }


    /**
     * Проведение всех этапов заказа
     * @param DiscountInterface $discount
     * @param BillingInterface $billing
     * @param SecurityInterface $security
     * @param CommunicationInterface $communication
     * @return void
     * @throws BillingException
     * @throws CommunicationException
     */

    public function checkoutProcess(): void {
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount = $this->discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount;

        $this->billing->pay($totalPrice);

        $user = $this->security->getUser();
        $this->communication->process($user, 'checkout_template');
    }
}