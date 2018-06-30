<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findOrCreate(Customer $customer)
    {
        if ($c = $this->findOneBy(['email' => $customer->getEmail()])) {
            return $c;
        }

        $this->_em->persist($customer);
        $this->_em->flush();

        return $customer;
    }
}
