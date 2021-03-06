<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forest
 *
 * @ORM\Table(name="forest")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\ForestRepository")
 */
class Forest
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
     * One Forest has One Island.
     * @ORM\OneToOne(targetEntity="Island", inversedBy="forest")
     * @ORM\JoinColumn(name="island_id", referencedColumnName="id")
     */
    private $island;

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
     * Set island
     *
     * @param \WorldBundle\Entity\Island $island
     *
     * @return Forest
     */
    public function setIsland(\WorldBundle\Entity\Island $island = null)
    {
        $this->island = $island;

        return $this;
    }

    /**
     * Get island
     *
     * @return \WorldBundle\Entity\Island
     */
    public function getIsland()
    {
        return $this->island;
    }
}
