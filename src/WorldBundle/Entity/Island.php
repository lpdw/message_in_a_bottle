<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Island
 *
 * @ORM\Table(name="island")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\IslandRepository")
 */
class Island
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
     * @ORM\Column(name="localisationX", type="integer")
     */
    private $localisationX;

    /**
     * @var int
     *
     * @ORM\Column(name="localisationY", type="integer")
     */
    private $localisationY;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=16)
     */
    private $type;

    /**
     * Many Islands have One WorldGame.
     * @ORM\ManyToOne(targetEntity="WorldGame", inversedBy="islands")
     * @ORM\JoinColumn(name="worldgame_id", referencedColumnName="id")
     */
    private $worldgame;

    /**
     * One Island has One Hut.
     * @ORM\OneToOne(targetEntity="Hut", mappedBy="island", cascade={"persist"})
     * @ORM\JoinColumn(name="hut_id", referencedColumnName="id")
     */
    private $hut;

    /**
     * One Island has One Beach.
     * @ORM\OneToOne(targetEntity="Beach", mappedBy="island", cascade={"persist"})
     * @ORM\JoinColumn(name="beach_id", referencedColumnName="id")
     */
    private $beach;

    /**
     * One Island has Many Monsters.
     * @ORM\OneToMany(targetEntity="Monster", mappedBy="island")
     */
    private $monsters;

    /**
     * One Island has One Forest.
     * @ORM\OneToOne(targetEntity="Forest", mappedBy="island", cascade={"persist"})
     * @ORM\JoinColumn(name="forest_id", referencedColumnName="id")
     */
    private $forest;

    /**
     * One Island have Many Players.
     * @ORM\OneToMany(targetEntity="Player", mappedBy="island", cascade={"persist"})
     */
    private $players;

    /**
     * Indicates if a player already poped on the island
     * @ORM\Column(name="deserted", type="boolean")
     */
    private $deserted = true;

    public function __construct() {
        $this->monsters = new ArrayCollection();
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

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set localisationX
     *
     * @param string $localisationX
     *
     * @return Island
     */
    public function setLocalisationX($localisationX)
    {
        $this->localisationX = $localisationX;

        return $this;
    }

    /**
     * Get localisationX
     *
     * @return string
     */
    public function getLocalisationX()
    {
        return $this->localisationX;
    }

    /**
     * Set localisationY
     *
     * @param integer $localisationY
     *
     * @return Island
     */
    public function setLocalisationY($localisationY)
    {
        $this->localisationY = $localisationY;

        return $this;
    }

    /**
     * Get localisationY
     *
     * @return int
     */
    public function getLocalisationY()
    {
        return $this->localisationY;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Island
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set worldgame
     *
     * @param \WorldBundle\Entity\WorldGame $worldgame
     *
     * @return Island
     */
    public function setWorldgame(\WorldBundle\Entity\WorldGame $worldgame = null)
    {
        $this->worldgame = $worldgame;

        return $this;
    }

    /**
     * Get worldgame
     *
     * @return \WorldBundle\Entity\WorldGame
     */
    public function getWorldgame()
    {
        return $this->worldgame;
    }

    /**
     * Set hut
     *
     * @param \WorldBundle\Entity\Hut $hut
     *
     * @return Island
     */
    public function setHut(\WorldBundle\Entity\Hut $hut = null)
    {
        $this->hut = $hut;

        return $this;
    }

    /**
     * Get hut
     *
     * @return \WorldBundle\Entity\Hut
     */
    public function getHut()
    {
        return $this->hut;
    }

    /**
     * Add monster
     *
     * @param \WorldBundle\Entity\Monster $monster
     *
     * @return Island
     */
    public function addMonster(\WorldBundle\Entity\Monster $monster)
    {
        $this->monsters[] = $monster;

        return $this;
    }

    /**
     * Remove monster
     *
     * @param \WorldBundle\Entity\Monster $monster
     */
    public function removeMonster(\WorldBundle\Entity\Monster $monster)
    {
        $this->monsters->removeElement($monster);
    }

    /**
     * Get monsters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonsters()
    {
        return $this->monsters;
    }

    /**
     * Set forest
     *
     * @param \WorldBundle\Entity\Forest $forest
     *
     * @return Island
     */
    public function setForest(\WorldBundle\Entity\Forest $forest = null)
    {
        $this->forest = $forest;

        return $this;
    }

    /**
     * Get forest
     *
     * @return \WorldBundle\Entity\Forest
     */
    public function getForest()
    {
        return $this->forest;
    }

    /**
     * Add player
     *
     * @param \WorldBundle\Entity\Player $player
     *
     * @return Island
     */
    public function addPlayer(\WorldBundle\Entity\Player $player)
    {
        $this->players[] = $player;
        $player->setIsland($this);
        return $this;
    }

    /**
     * Remove player
     *
     * @param \WorldBundle\Entity\Player $player
     */
    public function removePlayer(\WorldBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set beach
     *
     * @param \WorldBundle\Entity\Beach $beach
     *
     * @return Island
     */
    public function setBeach(\WorldBundle\Entity\Beach $beach = null)
    {
        $this->beach = $beach;

        return $this;
    }

    /**
     * Get beach
     *
     * @return \WorldBundle\Entity\Beach
     */
    public function getBeach()
    {
        return $this->beach;
    }
}
