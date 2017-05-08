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
    private $container;
    function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function createUser($username, $password, $email)
    {
        $User = new User();
        $User->setUsername($username);
        $User->setEmail($email);
        $encoder = $this->container->get("security.password_encoder");
        $User->setPassword($encoder->encodePassword($User, $password));

        return $User;
    }
}