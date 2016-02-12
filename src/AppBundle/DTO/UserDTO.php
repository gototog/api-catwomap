<?php
/**
 * User: goto
 * Date: 22/01/16
 * Time: 14:25
 */

namespace AppBundle\DTO;


use AppBundle\Entity\User;

class UserDTO
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $positionLat;
    public $positionLong;
    public $photo;

    public  function __construct(User $user)
    {
        $this->id = $user->getId() ;
        $this->firstname = $user->getFirstname() ;
        $this->lastname = $user->getLastname() ;
        $this->email = $user->getEmail() ;
        $this->positionLong = $user->getPositionLong() ;
        $this->positionLat = $user->getPositionLat() ;
        $this->photo = $user->getPhoto() ;
    }
}