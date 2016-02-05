<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Alert
 *
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlertRepository")
 */
class Alert
{
    const TYPE_EMERGENCY = "EMERGENCY";
    const TYPE_ALERT = "ALERT";
    const TYPE_DANGER = "DANGER";

    const BUNDLE_NAME = "AppBundle:Alert";
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
     * @ORM\Column(name="gmapCreatedPosition", type="string", length=255)
     */
    private $gmapCreatedPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finishedAt", type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" , inversedBy="alerts")
     */
    private $user;

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
     * Set gmapCreatedPosition
     *
     * @param string $gmapCreatedPosition
     *
     * @return Alert
     */
    public function setGmapCreatedPosition($gmapCreatedPosition)
    {
        $this->gmapCreatedPosition = $gmapCreatedPosition;

        return $this;
    }

    /**
     * Get gmapCreatedPosition
     *
     * @return string
     */
    public function getGmapCreatedPosition()
    {
        return $this->gmapCreatedPosition;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Alert
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Alert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set finishedAt
     *
     * @param \DateTime $finishedAt
     *
     * @return Alert
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt
     *
     * @return \DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

