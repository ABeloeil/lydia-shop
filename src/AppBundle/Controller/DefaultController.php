<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->redirectToRoute('app_shop');
    }

    /**
     * @Route("/shop/{path}", name="app_shop", options={"expose"=true}, requirements={"path"=".+"}, defaults={"path"="/"})
     * @Method("GET")
     *
     * @return Response
     */
    public function shopAction()
    {
        return $this->render('default/index.html.twig');
    }
}
