<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 07.05.2017
 * Time: 12:42
 */

namespace HomeBuhBundle\Utils;

use HomeBuhBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;

class UserUtil
{
    public static function createUser(Container $container, $username, $password, $email)
    {
        $User = new User();
        $User->setUsername($username);
        $User->setEmail($email);
        $encoder = $container->get("security.password_encoder");
        $User->setPassword($encoder->encodePassword($User, $password));

        return $User;
    }
    public static function getUserCategories(Container $container, User $user)
    {
        return $container
            ->get("doctrine")
            ->getRepository("HomeBuhBundle:Category")
            ->getCategories($user);
    }
    public static function getUserCategoriesForChoice(Container $container, User $user)
    {
        $categories = [];
        $catList = self::getUserCategories($container, $user);
        foreach ($catList as $cat) {
            $categories[$cat->getId()] = $cat->getName();
        }
        return $categories;
    }
    public static function getUserPaymentTypes(Container $container, User $user)
    {
        return $container
            ->get("doctrine")
            ->getRepository("HomeBuhBundle:Account")
            ->getAccounts($user);
    }
    public static function getUserPaymentTypesForChoice(Container $container, User $user)
    {
        $accounts = [];
        $accList = self::getUserPaymentTypes($container, $user);
        foreach ($accList as $acc) {
            $accounts[$acc->getId()] = $acc->getName();
        }
        return $accounts;
    }
    public static function getUserExpenses(Container $container, User $user, $dateFrom, $dateTo) {
        return $container
            ->get("doctrine")
            ->getRepository("HomeBuhBundle:Expense")
            ->getExpenses($user, $dateFrom, $dateTo);
    } 
}