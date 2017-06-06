<?php

namespace HomeBuhBundle\Controller;

use HomeBuhBundle\Utils\UserUtil;
use Proxies\__CG__\HomeBuhBundle\Entity\Expense;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends Controller
{
    /**
     * @param $datefrom
     * @param $dateto
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("data/get/expenses/{datefrom}/{dateto}", name = "get_expenses", options={"expose"=true})
     * @Template()
     */
    public function getExpensesAction($datefrom, $dateto)
    {
        $data = UserUtil::getUserExpenses($this->container, $this->getUser(), $datefrom, $dateto);
        return ['data' => $data];
    }

    /**
     * @param $id
     * @return Response
     * @Route("data/remove/expense/{expence_id}", name="remove_expense", options={"expose"=true})
     */
    public function delExpenseAction($expence_id) {
        $em = $this->getDoctrine()->getEntityManager();
        $exp = $em->getRepository("HomeBuhBundle:Expense")->find($expence_id);
        if($exp) {
            $em->remove($exp);
            $em->flush();
            return new Response("1");
        }
        return new Response("");
    }

    /**
     * @param $datefrom
     * @param $dateto
     * @param $acctype
     * @return Response
     * @Route("data/get/expenses/{datefrom}/{dateto}/{acctype}", name = "get_expenses_report", options={"expose"=true})
     * @Template()
     */
    public function repExpensesAction($datefrom, $dateto, $acctype) {
        $repResult = $this->getDoctrine()->getRepository("HomeBuhBundle:Expense")
            ->repExpenses($this->getUser(), $datefrom, $dateto, $acctype);
        return [
            'data' => $repResult,
        ];
    }

    /**
     * @param $datefrom
     * @param $dateto
     * @param $acctype
     * @param $category
     * @return Response
     * @Route("data/get/expenses_details/{datefrom}/{dateto}/{acctype}/{category}", name = "get_expenses_report_details", options={"expose"=true})
     * @Template()
     */
    public function repExpensesDetailAction($datefrom, $dateto, $acctype, $category) {
        $repResult = $this->getDoctrine()->getRepository("HomeBuhBundle:Expense")
            ->repExpensesDetails($this->getUser(), $datefrom, $dateto, $acctype, $category);
        return [
            'data' => $repResult,
        ];
    }

    /**
     * @return Response
     * @Route("data/get/categories", name = "get_categories")
     * @Template()
     */
    public function showUserCategoriesAction() {
        $data = [
            ['name' => 'vasya', 'ord' => '1'],
            ['name' => 'katya', 'ord' => '2'],
        ];
        $data = UserUtil::getUserCategories($this->container, $this->getUser());
        return [
            'data' => $data,
        ];
    }
}
