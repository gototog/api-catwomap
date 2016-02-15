<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * User
 * @UniqueEntity("email")
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    const BUNDLE_NAME = "AppBundle:User";
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;


    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="position_long", type="string", length=255, nullable=true)
     */
    private $positionLong;

    /**
     * @var string
     *
     * @ORM\Column(name="position_lat", type="string", length=255, nullable=true)
     */
    private $positionLat;
    /**
     * @var string
     *
     * @ORM\Column(name="position_city", type="string", length=255, nullable=true)
     */
    private $positionCity;
    /**
     * @var string
     *
     * @ORM\Column(name="position_dep", type="string", length=255, nullable=true)
     */
    private $positionDep;
    /**
     * @var string
     *
     * @ORM\Column(name="position_country", type="string", length=255, nullable=true)
     */
    private $positionCountry;
    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text", nullable=true)
     */
    private $photo;

    /**
     * @var Alert
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Alert" , mappedBy="userCreator")
     */
    private $alertsCreated;

    /**
     * @var Alert
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserHelpAlert" , mappedBy="alert")
     */
    private $userHelpAlerts;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return Alert
     */
    public function getAlertsCreated()
    {
        return $this->alertsCreated;
    }

    /**
     * @param Alert $alertsCreated
     */
    public function setAlertsCreated($alertsCreated)
    {
        $this->alertsCreated = $alertsCreated;
    }

    /**
     * @return Alert
     */
    public function getUserHelpAlerts()
    {
        return $this->userHelpAlerts;
    }

    /**
     * @param Alert $userHelpAlerts
     */
    public function setUserHelpAlerts($userHelpAlerts)
    {
        $this->userHelpAlerts = $userHelpAlerts;
    }



    /**
     * @param $password
     *
     * @return bool
     */
    public function checkPassword($password) {
        return $this->password == $password;
    }
}

