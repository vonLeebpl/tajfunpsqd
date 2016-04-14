<?php
/**
 * Created by PhpStorm.
 * User: JPa
 * Date: 2016-04-11
 * Time: 22:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClanRepository")
 * @ORM\Table(name="clan")
 */
class Clan
{
    /**
     * @ORM\OneToMany(targetEntity="EventAccountData", mappedBy="clan", cascade={"persist", "remove"})
     */
    private $members;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $tag;

    /**
     * @ORM\Column(type="integer")
     */
    private $members_count;

    /**
     * @ORM\Column(type="datetime", name="last_updated", nullable= true)
     * @Assert\DateTime()
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="datetime", name="last_event_update", nullable= true)
     * @Assert\DateTime()
     */
    private $lastEventUpdateDate;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Clan
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return Clan
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
     * Set tag
     *
     * @param string $tag
     * @return Clan
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set members_count
     *
     * @param integer $membersCount
     * @return Clan
     */
    public function setMembersCount($membersCount)
    {
        $this->members_count = $membersCount;

        return $this;
    }

    /**
     * Get members_count
     *
     * @return integer 
     */
    public function getMembersCount()
    {
        return $this->members_count;
    }

    /**
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     * @return Clan
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime 
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set lastEventUpdateDate
     *
     * @param \DateTime $lastEventUpdateDate
     * @return Clan
     */
    public function setLastEventUpdateDate($lastEventUpdateDate)
    {
        $this->lastEventUpdateDate = $lastEventUpdateDate;

        return $this;
    }

    /**
     * Get lastEventUpdateDate
     *
     * @return \DateTime 
     */
    public function getLastEventUpdateDate()
    {
        return $this->lastEventUpdateDate;
    }

    /**
     * Add members
     *
     * @param \AppBundle\Entity\EventAccountData $members
     * @return Clan
     */
    public function addMember(\AppBundle\Entity\EventAccountData $members)
    {
        $this->members[] = $members;

        return $this;
    }

    /**
     * Remove members
     *
     * @param \AppBundle\Entity\EventAccountData $members
     */
    public function removeMember(\AppBundle\Entity\EventAccountData $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }
}
