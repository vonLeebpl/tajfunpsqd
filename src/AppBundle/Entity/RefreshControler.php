<?php
/**
 * Created by PhpStorm.
 * User: JPa
 * Date: 2016-04-12
 * Time: 23:15
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="refreshcontroler")
 */
class RefreshControler
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $event_refresh;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set event_refresh
     *
     * @param \DateTime $eventRefresh
     * @return RefreshControler
     */
    public function setEventRefresh($eventRefresh)
    {
        $this->event_refresh = $eventRefresh;

        return $this;
    }

    /**
     * Get event_refresh
     *
     * @return \DateTime 
     */
    public function getEventRefresh()
    {
        return $this->event_refresh;
    }
}
