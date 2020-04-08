<?php


namespace Facade;


use Service\Billing\Exception\BillingException;
use Service\Billing\Transfer\Card;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\Sender\Email;
use Service\Discount\NullObject;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CheckoutFacade
{
    private $session;
    private $billing;
    private $discount;
    private $communication;
    private $security;

    /**
     * CheckoutFacade constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->billing = new Card();
        $this->discount = new NullObject();
        $this->communication = new Email();
        $this->session = $session;
        $this->security = new Security($this->session);
    }


    /**
     * Оформление заказа
     * @return void
     * @throws BillingException
     * @throws CommunicationException
     */

    public function checkout(): void
    {
        (new CheckoutProcess(
            $this->discount,
            $this->billing,
            $this->security,
            $this->communication))->checkoutProcess();
    }
}