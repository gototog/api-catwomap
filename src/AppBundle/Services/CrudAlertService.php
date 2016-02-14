<?php
namespace AppBundle\Services;

use AppBundle\DTO\AlertDTO;
use AppBundle\DTO\UserHelpAlertDTO;
use AppBundle\Entity\Alert;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHelpAlert;
use AppBundle\Repository\AlertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class CrudAlertService
{
    private $alertRepository;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::BUNDLE_NAME);
        $this->alertRepository = $em->getRepository(Alert::BUNDLE_NAME);

    }


    /**
     * @param $id
     *
     * @return AlertDTO
     */
    public function getAlertById($id) {
        $alert =  $this->alertRepository->getAlertById($id);
        return new AlertDTO($alert);
    }

    /**
     * @return \AppBundle\DTO\AlertDTO[]
     */
    public function getAlerts($city, $department, $country) {
        $alerts = $this->alertRepository->getAlerts($city, $department, $country);
        $dtos = [];
        foreach($alerts as $alert) {
            $dtos[]= new AlertDTO($alert);
        }
        return $dtos;
    }

    /**
     * @param $id
     */
    public function deleteAlertById($id) {
        $alert =  $this->alertRepository->getAlertById($id);

        $this->em->remove($alert);
        $this->em->flush();
    }

    /**
     * @param Alert $alert
     *
     * @return AlertDTO
     */
    public function createAlert(Alert $alert) {
        $alert->setCreatedAt( new \Datetime() );

        $infos = Geocoder::getLocation($alert->getPositionLat(), $alert->getPositionLong() );

        $city = Geocoder::getCityFromAddress($infos);
        $department = Geocoder::getDepartmentFromAddress($infos);
        $country = Geocoder::getCountryFromAddress($infos);

        $alert->setPositionCity($city);
        $alert->setPositionDep($department);
        $alert->setPositionCountry($country);

        $this->em->persist($alert);
        $this->em->flush();

        return new AlertDTO($alert);
    }


    /**
     * @param UserHelpAlert $userHelpAlert
     * @param User          $user
     * @param Alert         $alert
     *
     * @return UserHelpAlertDTO
     */
    public function createUserHelpAlert(UserHelpAlert $userHelpAlert, User $user, Alert $alert) {
        $userHelpAlert->setAlert( $alert );
        $userHelpAlert->setUser( $user );

        $this->em->persist($userHelpAlert);
        $this->em->flush();

        return new UserHelpAlertDTO($userHelpAlert);
    }

    /**
     * @param Alert $alert
     *
     * @return AlertDTO
     */
    public function updateAlert(Alert $alert) {
        $infos = Geocoder::getLocation($alert->getPositionLat(), $alert->getPositionLong() );
        $city = Geocoder::getCityFromAddress($infos);
        $department = Geocoder::getDepartmentFromAddress($infos);
        $country = Geocoder::getCountryFromAddress($infos);
        $alert->setPositionCity($city);
        $alert->setPositionDep($department);
        $alert->setPositionCountry($country);
        $this->em->persist($alert);
        $this->em->flush();
        return new AlertDTO($alert);
    }

    /**
     * @param Alert $alert
     *
     * @return AlertDTO
     */
    public function updateUserHelpAlert(UserHelpAlert $alert) {

        $this->em->persist($alert);
        $this->em->flush();
        return new UserHelpAlertDTO($alert);
    }


}