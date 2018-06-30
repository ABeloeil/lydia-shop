<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Product;
use AppBundle\Entity\Transaction;
use AppBundle\Form\CustomerType;
use AppBundle\Service\Payment;
use Buzz\Browser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em       = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/{id}/order", name="app_order")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Response
     */
    public function orderAction(Request $request, Product $product)
    {
        $customer = new Customer();
        $form     = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository(Customer::class)->findOrCreate($customer);

            try {
                $transaction = $this->get(Payment::class)->createRequest($customer, $product);

                return $this->redirect($transaction->getRedirectUrl());
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de votre commande.');
            }
        }

        return $this->render('default/order.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/success/{id}", name="app_transaction_success")
     * @Method({"GET", "POST"})
     *
     * @param Transaction $transaction
     *
     * @return Response
     */
    public function successAction(Transaction $transaction)
    {
        return $this->render('default/success.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/failed/{id}", name="app_transaction_failed")
     * @Method({"GET", "POST"})
     *
     * @param Transaction $transaction
     *
     * @return Response
     */
    public function failAction(Transaction $transaction)
    {
        return $this->render('default/failed.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/list", name="app_bundle_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $transactions = $em->getRepository(Transaction::class)->findAll();

        return $this->render('default/list.html.twig', [
            'transaction' => $transactions,
        ]);
    }
}

// dce298ee036b5318eea2d7dbd38b4510
