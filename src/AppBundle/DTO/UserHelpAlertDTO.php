<?php
/**
 * User: goto
 * Date: 22/01/16
 * Time: 14:32
 */

namespace AppBundle\DTO;


use AppBundle\Entity\UserHelpAlert;

class UserHelpAlertDTO
{

    private $id;
    private $user;
    private $isDeprecated;
    private $hasCalledPolice;



    public  function __construct(UserHelpAlert $helpAlertDTO)
    {
        $this->id             = $helpAlertDTO->getId() ;
        $this->user           = new UserDTO( $helpAlertDTO->getUser() ) ;
        $this->isDeprecated   = $helpAlertDTO->isDeprecated() ;
        $this->hasCalledPolice   = $helpAlertDTO->hasCalledPolice() ;

    }
}