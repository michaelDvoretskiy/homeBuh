<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Entity\Expense;
use HomeBuhBundle\Form\AddExpenseSumForm;
use HomeBuhBundle\Form\ChangePassword;
use HomeBuhBundle\Form\ReportExpensesForm;
use HomeBuhBundle\Form\ShowExpensesForm;
use HomeBuhBundle\Utils\UserUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name = "account")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $activeMenu = "mnuAdd";
        $sess = $request->getSession();
        if ($sess->has('activeMenu')) {
            $activeMenu = $sess->get('activeMenu');
            $sess->remove('activeMenu');
        }
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
        if (in_array($activeMenu, ['mnuOption','mnuPWD','mnuEditCat','mnuEditAcc'])) {
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
        } elseif ($activeMenu == "mnuReport") {
            $controller_name =  'report_expenses';
        } elseif ($activeMenu == "mnuOption" || $activeMenu == "mnuPWD") {
            $controller_name =  'change_password';
        } elseif ($activeMenu == "mnuEditCat") {
            $controller_name =  'get_categories';
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

    /**
     * @return Response
     * @Route("forms/expenses/report", name = "report_expenses")
     * @Template()
     */
    public function reportExpensesAction() {
        $accList = array_merge(
            ['0' => 'All types'],
            UserUtil::getUserPaymentTypesForChoice($this->container, $this->getUser())
        );

        $form = $this->createForm(ReportExpensesForm::class, null, ['acctypes' => $accList]);
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @return Response
     * @Route("forms/password/change", name = "change_password")
     * @Template()
     */
    public function changePasswordAction(Request $request) {
        $sess = $request->getSession();

        $form = $this->createForm(ChangePassword::class, null, ['action' => $this->generateUrl("change_password")]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $encoder = $this->container->get('security.password_encoder');
            $User = $this->getUser();
            if ($form->isValid()) {
                if ($data['newPass'] == $data['newPass2']) {
                    $newPass = $encoder->encodePassword($User, $data['newPass']);
                    $User->setPassword($newPass);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($User);
                    $em->flush();
                    return $this->redirectToRoute("account");
                }
            }
            $sess->set('activeMenu', 'mnuPWD');
            return $this->redirectToRoute("account");
        }

        return [
            'form' => $form->createView(),
        ];
    }
}