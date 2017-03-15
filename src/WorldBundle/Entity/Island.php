<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="localisationX", type="string", length=1)
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
     * @ORM\OneToOne(targetEntity="Hut", mappedBy="island")
     */
    private $hut;


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
}
