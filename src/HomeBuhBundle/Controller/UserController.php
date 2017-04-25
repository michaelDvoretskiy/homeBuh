<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Entity\Users;
use HomeBuhBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/auth", name = "auth")
     */
    public function authAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dbUserRow = $em->getRepository("HomeBuhBundle:Users")
            ->getAuthUser(
                $request->get('home_buh_bundle_login_form')['userName'],
                $request->get('home_buh_bundle_login_form')['passWord']
            );
        if($dbUserRow) {
            dump($dbUserRow);
            return new Response();
        }
        return $this->redirectToRoute("login");
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/")
     */
    public function getStartedAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("account");
        }
        return $this->redirectToRoute("login");
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/login", name="login")
     * @Template()
     */
    public function showLoginAction()
    {
        $form = $this->createForm(
            LoginForm::class,
            null,
            [
                'action' => $this->generateUrl("auth")
            ]
        );
        return ['form' => $form->createView()];
    }
}
