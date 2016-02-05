<?php
namespace AppBundle\Services;

use AppBundle\DTO\AlertDTO;
use AppBundle\Entity\Alert;
use AppBundle\Entity\User;
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
    public function getAlerts() {
        $alerts = $this->alertRepository->getAlerts();
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
    }

    /**
     * @param Alert $alert
     *
     * @return AlertDTO
     */
    public function createAlert(Alert $alert) {
        $this->em->persist($alert);
        $this->em->flush();

        return new AlertDTO($alert);
    }

    /**
     * @param Alert $alert
     *
     * @return AlertDTO
     */
    public function updateAlert(Alert $alert, $id) {
        $this->em->persist($alert);
        $this->em->flush();
        return new AlertDTO($alert);
    }


}