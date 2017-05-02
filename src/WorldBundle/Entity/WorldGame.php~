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
     * @ORM\OneToMany(targetEntity="Island", mappedBy="worldgame")
     */
    private $islands;

    /**
     *
     * @ORM\OneToMany(targetEntity="Player", mappedBy="worldgame")
     */
    private $players;

    public function __construct() {
      $this->islands = new ArrayCollection();
      $this->players = new ArrayCollection();
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
}
