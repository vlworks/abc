<?php

declare(strict_types=1);

namespace Controller;

use Exception;
use Framework\BaseController;
use Service\Billing\Exception\BillingException;
use Service\Communication\Exception\CommunicationException;
use Service\Order\Basket;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCheckoutController extends BaseController
{
    /**
     * Корзина
     * @param Request $request
     * @return Response
     * @throws Exception
     */

    /**
     * Оформление заказа
     * @param Request $request
     * @return Response
     * @throws BillingException
     * @throws CommunicationException
     */
    public function checkoutAction(Request $request): Response
    {
        $isLogged = (new Security($request->getSession()))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        (new Basket($request->getSession()))->checkout();

        return $this->render('order/checkout.html.php');
    }
}
