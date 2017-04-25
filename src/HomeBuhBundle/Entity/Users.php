<?php

namespace HomeBuhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="HomeBuhBundle\Entity\UsersRepository")
 */
class Users
{
    /**
     * @var string
     *
     * @ORM\Column(name="uname", type="string", length=50, nullable=false)
     */
    private $uname;

    /**
     * @var string
     *
     * @ORM\Column(name="passwd", type="string", length=50, nullable=false)
     */
    private $passwd;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set uname
     *
     * @param string $uname
     * @return Users
     */
    public function setUname($uname)
    {
        $this->uname = $uname;

        return $this;
    }

    /**
     * Get uname
     *
     * @return string 
     */
    public function getUname()
    {
        return $this->uname;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return Users
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;

        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
