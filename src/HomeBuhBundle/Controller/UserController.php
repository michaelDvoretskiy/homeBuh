<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("\login", name="login")
     * @Template()
     */
    public function showLoginAction()
    {
        $form = $this->createForm(
            LoginForm::class
        );
        return ['form' => $form->createView() ];
    }
}
