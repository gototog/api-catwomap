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
    public $gmap_position;

    public  function __construct(User $user)
    {
        $this->id = $user->getId() ;
        $this->firstname = $user->getFirstname() ;
        $this->lastname = $user->getLastname() ;
        $this->email = $user->getEmail() ;
        $this->gmap_position = $user->getGmapPosition() ;
    }
}