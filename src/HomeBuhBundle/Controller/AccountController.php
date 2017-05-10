<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Form\AddExpenseSum;
use HomeBuhBundle\Utils\UserUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{activeMenu}", name = "account")
     * @Template()
     */
    public function indexAction($activeMenu = 'mnuAdd')
    {
        return [
            'activeMenu' => $activeMenu,
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
        $categories = UserUtil::getUserCategoriesForChoice($this->container, $this->getUser());
        $paymentTypes = UserUtil::getUserPaymentTypesForChoice($this->container, $this->getUser());
            
        $form = $this->createForm(
            AddExpenseSum::class,
            null,
            [
                'categories' => $categories,
                'acctypes' => $paymentTypes,
            ]
        );
        return [
            'form' => $form->createView(),
        ];
    }
}
