<?php


namespace Builder;


use Service\Billing\Transfer\Card;
use Service\Communication\Sender\Email;
use Service\Discount\NullObject;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketBuilder
{
    private $billing;
    private $discount;
    private $communication;
    private $security;
    private $session;

    /**
     * BasketBuilder constructor.
     * @param $billing
     * @param $discount
     * @param $communication
     * @param $security
     */
    public function __construct(SessionInterface $session)
    {
        $this->billing = new Card();
        $this->discount = new NullObject();
        $this->communication = new Email();
        $this->security = new Security($this->session);
        $this->session =$session;
    }

    /**
     * @return Card
     */
    public function getBilling(): Card
    {
        return $this->billing;
    }

    /**
     * @return NullObject
     */
    public function getDiscount(): NullObject
    {
        return $this->discount;
    }

    /**
     * @return Email
     */
    public function getCommunication(): Email
    {
        return $this->communication;
    }

    /**
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }




}