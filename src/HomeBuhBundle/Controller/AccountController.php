<?php

namespace HomeBuhBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name = "account")
     */
    public function indexAction()
    {
        return new Response("111");
        //return $this->render('@HomeBuh/layout.html.twig');
    }
}
