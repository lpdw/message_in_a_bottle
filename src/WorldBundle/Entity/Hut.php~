<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hut
 *
 * @ORM\Table(name="hut")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\HutRepository")
 */
class Hut
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One Hut has One Island.
     * @ORM\OneToOne(targetEntity="Island", inversedBy="hut")
     * @ORM\JoinColumn(name="island_id", referencedColumnName="id")
     */
    private $island;



    /**
     * One Hut has Many Items.
     * @ORM\OneToMany(targetEntity="Item", mappedBy="hut")
     */
     private $chest;

    /**
     * One Hut has Many Logs.
     * @ORM\OneToMany(targetEntity="Log", mappedBy="hut")
     */
    private $logs;

    public function __construct() {
        $this->logs = new ArrayCollection();
        $this->chest = new ArrayCollection();
    }

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
     * Set island
     *
     * @param \WorldBundle\Entity\Island $island
     *
     * @return Hut
     */
    public function setIsland(\WorldBundle\Entity\Island $island = null)
    {
        $this->island = $island;

        return $this;
    }

    /**
     * Get island
     *
     * @return \WorldBundle\Entity\Island
     */
    public function getIsland()
    {
        return $this->island;
    }

    /**
     * Add chest
     *
     * @param \WorldBundle\Entity\Item $chest
     *
     * @return Hut
     */
    public function addChest(\WorldBundle\Entity\Item $chest)
    {
        $this->chest[] = $chest;

        return $this;
    }

    /**
     * Remove chest
     *
     * @param \WorldBundle\Entity\Item $chest
     */
    public function removeChest(\WorldBundle\Entity\Item $chest)
    {
        $this->chest->removeElement($chest);
    }

    /**
     * Get chest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChest()
    {
        return $this->chest;
    }

    /**
     * Add log
     *
     * @param \WorldBundle\Entity\Log $log
     *
     * @return Hut
     */
    public function addLog(\WorldBundle\Entity\Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove log
     *
     * @param \WorldBundle\Entity\Log $log
     */
    public function removeLog(\WorldBundle\Entity\Log $log)
    {
        $this->logs->removeElement($log);
    }

    /**
     * Get logs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
