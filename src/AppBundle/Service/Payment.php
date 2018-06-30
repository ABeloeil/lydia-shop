<?php

namespace AppBundle\Service;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Product;
use AppBundle\Entity\Transaction;
use Buzz\Browser;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Payment
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Browser
     */
    private $buzz;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $vendorToken;

    /**
     * Payment constructor.
     *
     * @param EntityManager $em
     * @param Browser       $buzz
     * @param string        $apiUrl
     * @param string        $vendorToken
     */
    public function __construct(EntityManager $em, RouterInterface $router, Browser $buzz, $apiUrl, $vendorToken)
    {
        $this->em          = $em;
        $this->router      = $router;
        $this->buzz        = $buzz;
        $this->apiUrl      = $apiUrl;
        $this->vendorToken = $vendorToken;
    }

    /**
     * Send a payment request to the lydia api.
     *
     * @param Customer $customer
     * @param Product  $product
     *
     * @return Transaction
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createRequest(Customer $customer, Product $product)
    {
        $transaction = $this->createTransaction($customer, $product);
        $data        = [
            'vendor_token'        => $this->vendorToken,
            'recipient'           => $customer->getEmail(),
            'amount'              => $transaction->getAmount(),
            'currency'            => $transaction->getCurrency(),
            'type'                => $transaction->getType(),
            'threeDSecure'        => 'no',
            'browser_success_url' => $this->router->generate('transaction_success', ['id' => $transaction->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            'browser_fail_url'    => $this->router->generate('transaction_failed', ['id' => $transaction->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
        $resp        = $this->buzz->post($this->apiUrl . '/api/request/do.json', [], http_build_query($data));
        $d           = json_decode($resp->getBody());

        $transaction->setRequestId($d->request_id)
                    ->setRequestUuid($d->request_uuid)
        ;
        $this->em->flush();

        return $transaction;
    }

    /**
     * Create and persist a new transaction.
     *
     * @param Customer $customer
     * @param Product  $product
     *
     * @return Transaction
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createTransaction(Customer $customer, Product $product)
    {
        $transaction = new Transaction();
        $transaction->setType('email')
                    ->setCustomer($customer)
                    ->setAmount($product->getPrice())
                    ->setCurrency('EUR')
        ;

        $this->em->persist($transaction);
        $this->em->flush();

        return $transaction;
    }
}
