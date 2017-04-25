<?php

namespace HomeBuhBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
    public function getAuthUser($userName, $passWord) {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u.uname')
            ->addSelect('u.id')
            ->from("HomeBuhBundle:Users","u")
            ->where("u.uname = :uname")
            ->andWhere("u.passwd = :pass")
            ->setParameter("uname",$userName)
            ->setParameter("pass", $passWord)
            ->getQuery()
            ->getOneOrNullResult();
    }
}