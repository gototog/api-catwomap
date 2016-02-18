<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraint\BothFieldsConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Alert
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlertRepository")
 */
class Alert
{
    const TYPE_EMERGENCY = "EMERGENCY";
    const TYPE_ALERT = "vol";
    const TYPE_DANGER = "accident";
    const TYPE_HELP= "helpme";
    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_CLOSED = "CLOSED";
    const STATUS_DEPRECATED = "DEPRECATED";

    const BUNDLE_NAME = "AppBundle:Alert";
    /**
     * @var int
     *
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="position_long", type="string", length=255)
     */
    private $positionLong;
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="position_lat", type="string", length=255)
     */
    private $positionLat;
    /**
     * @var string
     *
     * @ORM\Column(name="position_city", type="string", length=255)
     */
    private $positionCity;
    /**
     * @var string
     *
     * @ORM\Column(name="position_dep", type="string", length=255)
     */
    private $positionDep;
    /**
     * @var string
     *
     * @ORM\Column(name="position_country", type="string", length=255)
     */
    private $positionCountry;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status = self::STATUS_ACTIVE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finishedAt", type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy="alertsCreated")
     */
    private $userCreator;

    /**
     * @var UserHelpAlert
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserHelpAlert" , mappedBy="alert")
     */
    private $userHelpAlerts = [];

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
     * @return string
     */
    public function getPositionLong()
    {
        return $this->positionLong;
    }

    /**
     * @param string $positionLong
     */
    public function setPositionLong($positionLong)
    {
        $this->positionLong = $positionLong;
    }

    /**
     * @return string
     */
    public function getPositionLat()
    {
        return $this->positionLat;
    }

    /**
     * @param string $positionLat
     */
    public function setPositionLat($positionLat)
    {
        $this->positionLat = $positionLat;
    }

    /**
     * @return string
     */
    public function getPositionCity()
    {
        return $this->positionCity;
    }

    /**
     * @param string $positionCity
     */
    public function setPositionCity($positionCity)
    {
        $this->positionCity = $positionCity;
    }

    /**
     * @return string
     */
    public function getPositionDep()
    {
        return $this->positionDep;
    }

    /**
     * @param string $positionDep
     */
    public function setPositionDep($positionDep)
    {
        $this->positionDep = $positionDep;
    }

    /**
     * @return string
     */
    public function getPositionCountry()
    {
        return $this->positionCountry;
    }

    /**
     * @param string $positionCountry
     */
    public function setPositionCountry($positionCountry)
    {
        $this->positionCountry = $positionCountry;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime $finishedAt
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;
    }

    /**
     * @return User
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }

    /**
     * @param User $userCreator
     */
    public function setUserCreator(User $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    /**
     * @return UserHelpAlert[]
     */
    public function getUserHelpAlerts()
    {
        return $this->userHelpAlerts;
    }

    /**
     * @param UserHelpAlert[] $userHelpAlerts
     */
    public function setUserHelpAlerts( $userHelpAlerts)
    {
        $this->userHelpAlerts = $userHelpAlerts;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = strtoupper($status);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }





}

