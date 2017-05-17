<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Entity\Expense;
use HomeBuhBundle\Form\AddExpenseSumForm;
use HomeBuhBundle\Form\ShowExpensesForm;
use HomeBuhBundle\Utils\UserUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("content/get/{activeMenu}", name = "get_content", options={"expose"=true})
     */
    public function showContentAction($activeMenu)
    {
        $controller_name = "";
        if ($activeMenu == "mnuAdd") {
            $controller_name = 'get_new_expense_form';             
        } elseif ($activeMenu == "mnuView") {
            $controller_name =  'view_expenses';
        } else {
            $controller_name =  '';
        }
        if ($controller_name) {
            $routes = $this->get('router')->getRouteCollection();
            $controller =  $routes->get($controller_name)->getDefaults()['_controller'];
            $response = $this->forward($controller);
        } else {
            $response = new Response();
        }
        return $response;
    }

    /**
     * @return Response
     * @Route("forms/get/new_expense", name = "get_new_expense_form")
     * @Template()
     */
    public function addExpenseAction(Request $request)
    {
        $categories = UserUtil::getUserCategories($this->container, $this->getUser());
        $paymentTypes = UserUtil::getUserPaymentTypes($this->container, $this->getUser());

        $form = $this->createForm(
            AddExpenseSumForm::class,
            new Expense(),
            [
                'categories' => $categories,
                'acctypes' => $paymentTypes,
                'action' => $this->generateUrl("get_new_expense_form"),
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $expense = $form->getData();
            $expense->setUid($this->getUser()->getId());

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($expense);
            $em->flush();
            
            return $this->redirectToRoute("account");
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @return Response
     * @Route("forms/expenses/get", name = "view_expenses")
     * @Template()
     */
    public function viewExpensesAction() {
        $form = $this->createForm(ShowExpensesForm::class);
        return [
            'form' => $form->createView(),
        ];
    }
}