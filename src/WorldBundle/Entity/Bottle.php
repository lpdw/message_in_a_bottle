<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Bottle
 *
 * @ORM\Table(name="bottle")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\BottleRepository")
 */
class Bottle extends Usable
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
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    public function __construct() {
      $this->setName("Bottle");
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
     * Set message
     *
     * @param string $message
     *
     * @return Bottle
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
