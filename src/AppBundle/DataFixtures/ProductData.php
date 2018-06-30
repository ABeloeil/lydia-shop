<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductData extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $manager->persist(
                (new Product())
                    ->setName($data[0])
                    ->setPrice($data[1])
            );
        }

        $manager->flush();
    }

    private function getData()
    {
        return [
            ['Beer', 4.99],
            ['Burger', 14.99],
            ['Ice cream', 7.99],
        ];
    }
}
