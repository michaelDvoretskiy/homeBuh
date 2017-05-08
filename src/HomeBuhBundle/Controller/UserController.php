<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Entity\Users;
use HomeBuhBundle\Form\LoginForm;
use HomeBuhBundle\Utils\UserUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("login", name = "login")
     * @Template("@HomeBuh/User/showLogin.html.twig")
     */
    public function loginAction()
    {
        $auth = $this->get("security.authentication_utils");
        return [
            "form" => $this->createForm(LoginForm::class)->createView(),
            "last_username" => $auth->getLastUsername(),
            "err" => $auth->getLastAuthenticationError(),
        ];
    }

    /**
     * @return Response
     * @Route("add_admin", name = "add_admin")
     */
    public function tempAddUserAction()
    {
        $User = (new UserUtil($this->container))->createUser("admin", 1111, "admin@mail.homebuh");
        $em = $this->getDoctrine()->getManager();
        $em->persist($User);
        $em->flush();

        return new Response("Successfully added");
    }
}
