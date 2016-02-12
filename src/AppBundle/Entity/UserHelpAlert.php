<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Alert
 *
 * @ORM\Table(name="user_help_alert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserHelpAlertRepository")
 */
class UserHelpAlert
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy="userHelpAlerts")
     */
    private $user;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Alert" , inversedBy="userHelpAlerts")
     */
    private $alert;

    /**
     * @var bool
     * @ORM\Column(name="is_deprecated", type="boolean")
     */
    private $isDeprecated;
    /**
     * @var bool
     * @ORM\Column(name="has_called_police", type="boolean")
     */
    private $hasCalledPolice;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * @param User $alert
     */
    public function setAlert($alert)
    {
        $this->alert = $alert;
    }

    /**
     * @return boolean
     */
    public function isDeprecated()
    {
        return $this->isDeprecated;
    }

    /**
     * @param boolean $isDeprecated
     */
    public function setIsDeprecated($isDeprecated)
    {
        $this->isDeprecated = $isDeprecated;
    }

    /**
     * @return boolean
     */
    public function hasCalledPolice()
    {
        return $this->hasCalledPolice;
    }

    /**
     * @param boolean $hasCalledPolice
     */
    public function setHasCalledPolice($hasCalledPolice)
    {
        $this->hasCalledPolice = $hasCalledPolice;
    }



}

