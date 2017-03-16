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
     * One Beach has Many Items.
     * @ORM\OneToMany(targetEntity="Item", mappedBy="beach")
     */
    private $drops;


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
}
