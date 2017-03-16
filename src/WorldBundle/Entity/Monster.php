<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Monster
 *
 * @ORM\Table(name="monster")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\MonsterRepository")
 */
class Monster
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
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * Many Monsters have One Island.
     * @ORM\ManyToOne(targetEntity="Island", inversedBy="monsters")
     * @ORM\JoinColumn(name="island_id", referencedColumnName="id")
     */
    private $island;

    /**
     * One Monster has Many Items.
     * @ORM\OneToMany(targetEntity="Item", mappedBy="monster")
     */
    private $loot;

    public function __construct() {
        $this->loot = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Monster
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
     * Set level
     *
     * @param integer $level
     *
     * @return Monster
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }
}
