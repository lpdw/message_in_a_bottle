<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * WorldGame
 *
 * @ORM\Table(name="world_game")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\WorldGameRepository")
 */
class WorldGame
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
     * @var array
     *
     * @ORM\Column(name="grid", type="array")
     */
    private $grid;


    /**
     * One WorldGame has Many Islands.
     * @ORM\OneToMany(targetEntity="Island", mappedBy="worldgame", cascade={"remove"})
     */
    private $islands;


    public function __construct() {
      $this->islands = new ArrayCollection();
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
     * Set grid
     *
     * @param array $grid
     *
     * @return WorldGame
     */
    public function setGrid($grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * Get grid
     *
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Add island
     *
     * @param \WorldBundle\Entity\Island $island
     *
     * @return WorldGame
     */
    public function addIsland(\WorldBundle\Entity\Island $island)
    {
        $this->islands[] = $island;

        return $this;
    }

    /**
     * Remove island
     *
     * @param \WorldBundle\Entity\Island $island
     */
    public function removeIsland(\WorldBundle\Entity\Island $island)
    {
        $this->islands->removeElement($island);
    }

    /**
     * Get islands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIslands()
    {
        return $this->islands;
    }
}
