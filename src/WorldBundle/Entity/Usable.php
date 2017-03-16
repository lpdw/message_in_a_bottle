<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usable
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"usable" = "Usable", "bottle" = "Bottle"})
 *
 * @ORM\Table(name="usable")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\UsableRepository")
 */
class Usable extends Item
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nbUsage", type="integer", nullable=true)
     */
    private $nbUsage;


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
     * Set nbUsage
     *
     * @param integer $nbUsage
     *
     * @return Usable
     */
    public function setNbUsage($nbUsage)
    {
        $this->nbUsage = $nbUsage;

        return $this;
    }

    /**
     * Get nbUsage
     *
     * @return int
     */
    public function getNbUsage()
    {
        return $this->nbUsage;
    }
}
