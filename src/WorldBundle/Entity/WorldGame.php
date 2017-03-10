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
     * @OneToMany(targetEntity="Island", mappedBy="worldgame")
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
}
