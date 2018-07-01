<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Product;
use AppBundle\Entity\Transaction;
use AppBundle\Form\CustomerType;
use AppBundle\Model\TransactionStatus;
use AppBundle\Service\Payment;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\RouteResource("Transaction")
 */
class TransactionController extends FOSRestController
{
    /**
     * List all transactions
     *
     * @Rest\View()
     *
     * @return Transaction[]|array
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $transactions = $em->getRepository(Transaction::class)->findAll();

        return $transactions;
    }

    /**
     * Create a transaction and send a request to the lydia api.
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Transaction|\Symfony\Component\Form\FormInterface
     * @throws \Exception
     */
    public function postAction(Request $request, Product $product)
    {
        $customer = new Customer();
        $form     = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository(Customer::class)->findOrCreate($customer);

            try {
                $transaction = $this->get(Payment::class)->createRequest($customer, $product);

                return $transaction;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }

        return $form;
    }

    /**
     * Set a transaction to success.
     *
     * @Rest\View()
     *
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function putSuccessAction(Transaction $transaction)
    {
        $em = $this->getDoctrine()->getManager();

        $transaction->setStatus(TransactionStatus::SUCCESS);
        $em->flush();

        return $transaction;
    }

    /**
     * Set a transaction to failed.
     *
     * @Rest\View()
     *
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function putFailedAction(Transaction $transaction)
    {
        $em = $this->getDoctrine()->getManager();

        $transaction->setStatus(TransactionStatus::FAILED);
        $em->flush();

        return $transaction;
    }

    /**
     * Set a transaction to expired.
     *
     * @Rest\View()
     *
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function putExpiredAction(Transaction $transaction)
    {
        $em = $this->getDoctrine()->getManager();

        $transaction->setStatus(TransactionStatus::EXPIRED);
        $em->flush();

        return $transaction;
    }
}
