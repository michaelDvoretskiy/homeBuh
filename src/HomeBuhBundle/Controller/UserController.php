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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/auth_old", name = "auth_old")
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
        return $this->redirectToRoute("login_old");
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/old")
     */
    public function getStartedAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("account_old");
        }
        return $this->redirectToRoute("login_old");
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/login_old", name="login_old")
     * @Template()
     */
    public function showLoginAction()
    {
        $form = $this->createForm(
            LoginForm::class,
            null,
            [
                'action' => $this->generateUrl("auth_old")
            ]
        );
        return ['form' => $form->createView()];
    }

    /**
     * @Route("login", name = "login")
     * @Template("@HomeBuh/User/login.html.twig")
     */
    public function loginAction()
    {
        $auth = $this->get("security.authentication_utils");
        return [
            //"form" => $this->createForm(LoginForm::class,null,["method" => "POST"])->createView(),
            "last_username" => $auth->getLastUsername(),
            "error" => $auth->getLastAuthenticationError(),
        ];
    }

    /**
     * @return Response
     * @Route("admin/temp", name = "temp_admin")
     */
    public function tempAdminAction()
    {
        return new Response("<html><body>admin</body></html>");
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
