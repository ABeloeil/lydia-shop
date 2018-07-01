<?php

namespace AppBundle\Service;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Product;
use AppBundle\Entity\Transaction;
use Buzz\Browser;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Payment
{
    /**
     * @var ObjectManager
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
     * @param ObjectManager   $em
     * @param RouterInterface $router
     * @param Browser         $buzz
     * @param string          $apiUrl
     * @param string          $vendorToken
     */
    public function __construct(ObjectManager $em, RouterInterface $router, Browser $buzz, $apiUrl, $vendorToken)
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
        $query       = [
            'vendor_token'        => $this->vendorToken,
            'recipient'           => $customer->getEmail(),
            'amount'              => $transaction->getAmount(),
            'currency'            => $transaction->getCurrency(),
            'type'                => $transaction->getType(),
            'threeDSecure'        => 'no',
            'browser_success_url' => $this->router->generate('app_shop', [
                'path' => "order/{$transaction->getId()}/success",
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'browser_fail_url'    => $this->router->generate('app_shop', [
                'path' => "order/{$transaction->getId()}/failed",
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'confirm_url'         => $this->router->generate('put_transaction_success', [
                'transaction' => $transaction->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'          => $this->router->generate('put_transaction_failed', [
                'transaction' => $transaction->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'expire_url'          => $this->router->generate('put_transaction_expired', [
                'transaction' => $transaction->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        $resp = $this->buzz->post($this->apiUrl . '/api/request/do.json', [], http_build_query($query));
        $body = json_decode($resp->getBody());

        $transaction->setRequestId($body->request_id)->setRequestUuid($body->request_uuid)
                    ->setRedirectUrl($body->mobile_url);

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
        $transaction->setType('email')->setCustomer($customer)->setAmount($product->getPrice())->setCurrency('EUR');

        $this->em->persist($transaction);
        $this->em->flush();

        return $transaction;
    }
}
