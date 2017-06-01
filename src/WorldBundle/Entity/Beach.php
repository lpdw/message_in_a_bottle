<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Beach
 *
 * @ORM\Table(name="beach")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\BeachRepository")
 */
class Beach
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
     * Many Beach has Many Items.
     * @ORM\ManyToMany(targetEntity="Item",cascade={"persist"})
     * @ORM\JoinTable(name="beachs_items",
     *  joinColumns={@ORM\JoinColumn(name="beach_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")})
     */
    private $drops;

    /**
     * One Beach has One Island.
     * @ORM\OneToOne(targetEntity="Island", inversedBy="beach")
     * @ORM\JoinColumn(name="island_id", referencedColumnName="id")
     */
    private $island;


    public function __construct() {
        $this->drops = new ArrayCollection();
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
     * Add drop
     *
     * @param \WorldBundle\Entity\Item $drop
     *
     * @return Beach
     */
    public function addDrop(\WorldBundle\Entity\Item $drop)
    {
        $this->drops[] = $drop;

        return $this;
    }

    /**
     * Remove drop
     *
     * @param \WorldBundle\Entity\Item $drop
     */
    public function removeDrop(\WorldBundle\Entity\Item $drop)
    {
        $this->drops->removeElement($drop);
    }

    /**
     * RemoveAll drop
     *
     */
    public function removeAllDrop()
    {
        foreach ($this->drops as $key => $drop) {
            if($drop->getName() !== "bottle"){
                $this->removeDrop($drop);
            }
        }
    }

    /**
     * Get drops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDrops()
    {
        return $this->drops;
    }

    /**
     * Set island
     *
     * @param \WorldBundle\Entity\Island $island
     *
     * @return Beach
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
}
