<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Transaction;
use AppBundle\Form\CustomerType;
use Buzz\Browser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    const url          = 'https://homologation.lydia-app.com';
    const vendor_token = '58385365be57f651843810';

    /**
     * @Route("/", name="homepage")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $customer = new Customer();
        $form     = $this->createForm(CustomerType::class, $customer);
        $d        = null;
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $em       = $this->getDoctrine()
                             ->getManager()
            ;
            $customer = $em->getRepository(Customer::class)
                           ->findOrCreate($customer)
            ;

            $transaction = new Transaction();
            $transaction->setCustomer($customer)
                        ->setAmount(15.99)
                        ->setCurrency('EUR')
                        ->setType('email')
            ;
            $em->persist($transaction);
            $em->flush();

            $client = new Browser();
            $data   = [
                'vendor_token'        => self::vendor_token,
                'recipient'           => $customer->getEmail(),
                'amount'              => 15.99,
                'currency'            => 'EUR',
                'type'                => 'email',
                'threeDSecure'        => 'no',
                'browser_success_url' => $this->generateUrl('transaction_success', ['id' => $transaction->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                'browser_fail_url'    => $this->generateUrl('transaction_failed', ['id' => $transaction->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            ];

            $resp = $client->post(self::url . '/api/request/do.json', [], http_build_query($data));
            $d    = json_decode($resp->getBody());

            $transaction->setRequestId($d->request_id)
                        ->setRequestUuid($d->request_uuid)
            ;
            $em->flush();
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'd'    => $d,
        ]);
    }

    /**
     * @Route("/success/{id}", name="transaction_success")
     * @Method({"GET", "POST"})
     *
     * @param Transaction $transaction
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successAction(Transaction $transaction)
    {
        return $this->render('default/success.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/failed/{id}", name="transaction_failed")
     * @Method({"GET", "POST"})
     *
     * @param Transaction $transaction
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
        $client = new Browser();
        $resp   = $client->post(self::url . '/api/transaction/list.json', [], http_build_query([
            'vendor_token' => self::vendor_token,
            'startDate'    => '2018-06-06 00:00:00',
            'endDate'      => '2018-07-07 00:00:00',
        ]));

        return $this->render('default/list.html.twig', ['requests' => [],]);
    }
}

// dce298ee036b5318eea2d7dbd38b4510
