<?php
/**
 * Created by PhpStorm.
 * User: JPa
 * Date: 2016-04-16
 * Time: 10:17
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class CronTask
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     */
    private $commands;

    /**
     * @ORM\Column(name="`interval`", type="integer")
     */
    private $interval;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastrun;



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
     * Set name
     *
     * @param string $name
     * @return CronTask
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set commands
     *
     * @param array $commands
     * @return CronTask
     */
    public function setCommands($commands)
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * Get commands
     *
     * @return array 
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Set interval
     *
     * @param integer $interval
     * @return CronTask
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Get interval
     *
     * @return integer 
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Set lastrun
     *
     * @param \DateTime $lastrun
     * @return CronTask
     */
    public function setLastrun($lastrun)
    {
        $this->lastrun = $lastrun;

        return $this;
    }

    /**
     * Get lastrun
     *
     * @return \DateTime 
     */
    public function getLastrun()
    {
        return $this->lastrun;
    }
}
