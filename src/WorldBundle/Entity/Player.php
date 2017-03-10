<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\PlayerRepository")
 */
class Player
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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32)
     */
    private $status;

    /**
     * Many Players have One WorldGame.
     * @ORM\ManyToOne(targetEntity="WorldGame", inversedBy="players")
     * @ORM\JoinColumn(name="worldgame_id", referencedColumnName="id")
     */
    private $worldgame;

    /**
     *
     * @ORM\OneToMany(targetEntity="Inventory", mappedBy="player")
     */
    private $inventory;

    /**
     *
     * @ORM\OneToMany(targetEntity="Equipment", mappedBy="players")
     */
    private $equipment;

    public function __construct() {
      $this->inventory = new ArrayCollection();
      $this->equipment = new ArrayCollection();
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
     * Set status
     *
     * @param string $status
     *
     * @return Player
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}

