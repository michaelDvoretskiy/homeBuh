<?php

namespace HomeBuhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expenses
 *
 * @ORM\Table(name="expenses", indexes={@ORM\Index(name="account", columns={"account"}), @ORM\Index(name="cat", columns={"cat"})})
 * @ORM\Entity(repositoryClass="ExpenseRepository")
 */
class Expense
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=50, nullable=false, options={"default" : ""})
     */
    private $text = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="summa", type="integer", nullable=false)
     */
    private $summa;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer", nullable=false)
     */
    private $uid;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="HomeBuhBundle\Entity\Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="HomeBuhBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat", referencedColumnName="id")
     * })
     */
    private $cat;



    /**
     * Set data
     *
     * @param \DateTime $data
     * @return Expense
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Expense
     */
    public function setText($text = '')
    {
        if (!$text) {
            $text = '';
        }
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set summa
     *
     * @param integer $summa
     * @return Expense
     */
    public function setSumma($summa)
    {
        $this->summa = $summa;

        return $this;
    }

    /**
     * Get summa
     *
     * @return integer 
     */
    public function getSumma()
    {
        return $this->summa;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     * @return Expense
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return integer 
     */
    public function getUid()
    {
        return $this->uid;
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

    /**
     * Set account
     *
     * @param \HomeBuhBundle\Entity\Account $account
     * @return Expense
     */
    public function setAccount(\HomeBuhBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \HomeBuhBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set cat
     *
     * @param \HomeBuhBundle\Entity\Category $cat
     * @return Expense
     */
    public function setCat(\HomeBuhBundle\Entity\Category $cat = null)
    {
        $this->cat = $cat;

        return $this;
    }

    /**
     * Get cat
     *
     * @return \HomeBuhBundle\Entity\Category 
     */
    public function getCat()
    {
        return $this->cat;
    }

    /**
     * @ORM\PrePersist()
     */
    function onPrePersist() {
        if (!$this->getText()) {
            $this->setText();
        }
    }
}
