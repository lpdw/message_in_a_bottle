<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
