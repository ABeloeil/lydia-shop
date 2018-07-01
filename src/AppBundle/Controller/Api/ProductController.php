<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Product;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("Product")
 */
class ProductController extends FOSRestController
{
    /**
     * Lists all courses.
     *
     * @Rest\View
     *
     * @return array
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();

        return $products;
    }
}
