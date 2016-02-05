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
    public $type;
    public $created_at;
    public $finished_at;
    public $gmap_created_position;

public  function __construct(Alert $alert)
{
    $this->id = $alert->getId() ;
    $this->type = $alert->getType() ;
    $this->created_at = $alert->getCreatedAt() ;
    $this->finished_at = $alert->getFinishedAt() ;
    $this->gmap_created_position = $alert->getGmapCreatedPosition();
}
}