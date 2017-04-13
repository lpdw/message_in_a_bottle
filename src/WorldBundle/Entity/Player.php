<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * Many Players have One Island.
     * @ORM\OneToMany(targetEntity="Island", mappedBy="players")
     */
    private $localisation;

    /**
     *
     * @ORM\OneToOne(targetEntity="Inventory", mappedBy="player")
     */
    private $inventory;

    /**
     *
     * @ORM\OneToMany(targetEntity="Equipment", mappedBy="players")
     */
    private $equipment;



    public function __construct() {
      $this->inventory = new Inventory();
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

    /**
     * Pick a objects
     *
     * @return string
     */
    public function PickObject($objects)
    {
        if(gettype($objects) == "string"){

            if($this->limitInventory()){
                return "L'\object {$objects['item']->name} n'a pas pu être ajouté car la limite de l'inventaire à été atteint";
            }
            else{
                $this->inventory->addItem($objects);
                return "L\'object à bien été ajouté";
            }
        }
        else{
            $msg = "";
            foreach ($objects as $object => $value) {
                if($this->limitInventory($value['quantity'])){
                    // dump($this->inventory);
                    return "L'\object {$value['item']->getName()} n'a pas pu être ajouté car la limite de l'inventaire à été atteint";
                }
                else{
                    $this->inventory->addItem($value);
                }
            }
            // dump($this->inventory);
            // die();
            return "Les objects ont bien été ajouté";
        }
    }

    /**
    * Test limit of Inventory
    *
    * @return boolean
    */
    public function limitInventory($quantity)
    {  
        // echo("Count de l'inventaire : ");
        // dump($this->inventory);
        if(($this->inventory->getQuantity() + $quantity) >= 50){
            return true;
        }
        else{return false;}
    }


    /**
    * Test random
    *
    * @return boolean
    */
    public function randomisTrue($pourcent)
    {
        return (rand(1,100) <= $pourcent) ? true: false;
    }
}