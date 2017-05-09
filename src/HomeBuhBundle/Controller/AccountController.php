<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Form\AddExpenseSum;
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
            'activeMenu' => 'mnuAdd',
        ];
    }
    /**
     * @param $activeMenu
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("menus/get/dependent/{activeMenu}", name = "get_dependent_menu", options={"expose"=true})
     */
    public function depMenuAction($activeMenu)
    {
        if ($activeMenu == "mnuOption") {
            return $this->render("@HomeBuh/Account/optionsMenu.html.twig");    
        }
        if ($activeMenu == "mnuLogout") {
            return $this->redirectToRoute("logout");
        }
        return new Response();            
    }

    /**
     * @param $activeMenu
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("content/get/{activeMenu}", name = "get_content")
     */
    public function showContentAction($activeMenu)
    {
        $routes = $this->get('router')->getRouteCollection();
        $controller =  $routes->get('get_new_expense_form')->getDefaults()['_controller'];
        $response = $this->forward($controller);
        return $response;
    }

    /**
     * @return Response
     * @Route("forms/get/new_expense", name = "get_new_expense_form")
     * @Template()
     */
    public function addExpenseAction()
    {
        $categories = [
            '0' => 'Base category',
            '1' => 'Additional one',
        ];
        $form = $this->createForm(AddExpenseSum::class, null, ['categories' => $categories]);
        return [
            'form' => $form->createView(),
        ];
    }
}
