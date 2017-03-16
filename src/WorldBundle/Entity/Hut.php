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
    private $logs;

    /**
     * One Hut has Many Logs.
     * @ORM\OneToMany(targetEntity="Log", mappedBy="hut")
     */
    private $chest;

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
}
