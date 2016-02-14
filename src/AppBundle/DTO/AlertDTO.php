<?php
/**
 * User: goto
 * Date: 22/01/16
 * Time: 14:32
 */

namespace AppBundle\DTO;


use AppBundle\Entity\Alert;

class AlertDTO
{

    public $id;

    public $positionLong;
    public $positionLat;
    public $positionCity;
    public $positionDep;
    public $positionCountry;
    public $category;
    public $createdAt;
    public $finishedAt;
    public $userCreator;
    public $userHelpAlerts;
    public $nbAlertsDeprecated;



    public  function __construct(Alert $alert)
    {
        $this->id           = $alert->getId() ;


        $this->positionLong     = $alert->getPositionLong();
        $this->positionLat      = $alert->getPositionLat();
        $this->positionCity     = $alert->getPositionCity();
        $this->positionDep      = $alert->getPositionDep();
        $this->positionCountry  = $alert->getPositionCountry();
        $this->category         = $alert->getCategory();
        $this->createdAt        = $alert->getCreatedAt();
        $this->finishedAt       = $alert->getFinishedAt();
        $user = new UserDTO( $alert->getUserCreator() );
        $this->userCreator      = $user;
        $nbDeprecated = 0;

        foreach ($alert->getUserHelpAlerts() as $userHelpAlert) {
            $this->userHelpAlerts[] = new UserHelpAlertDTO($userHelpAlert);
            if($userHelpAlert->isDeprecated()) {
                $nbDeprecated++;
            }
        }

        $this->nbAlertsDeprecated = $nbDeprecated;


    }
}