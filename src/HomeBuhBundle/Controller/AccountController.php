<?php

namespace HomeBuhBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name = "account")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'activeMenu' => 'mnuOption',
        ];
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("menues/get/dependent", "get_dapendent
     */
    public function depMenuAction($activeMenu)
    {
        if ($activeMenu == "mnuOption") {
            return $this->render("@HomeBuh/Account/optionsMenu.html.twig");    
        }
        return new Response();            
    }
}
