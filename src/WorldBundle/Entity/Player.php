<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use WorldBundle\Entity\Bottle;

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
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32)
     */
    private $status;

    /**
     *
     * @ORM\OneToOne(targetEntity="Inventory", mappedBy="player",cascade={"persist"})
     */
    private $inventory;

    /**
     *
     * @ORM\OneToMany(targetEntity="Equipment", mappedBy="players")
     */
    private $equipment;

    /**
     * Many Player have One Island.
     * @ORM\ManyToOne(targetEntity="Island", inversedBy="players", cascade={"persist"})
     * @ORM\JoinColumn(name="island_id", referencedColumnName="id")
     */
    private $island;


    public function __construct() {
      $this->inventory = new Inventory();
      $this->inventory->setQuantity(0);
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
     * Set name
     *
     * @param string $name
     *
     * @return Player
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
     * Set island
     *
     * @param Island $island
     *
     * @return Player
     */
    public function setIsland($island)
    {
        $this->island = $island;

        return $this;
    }

    /**
     * Get island
     *
     * @return Island
     */
    public function getIsland()
    {
        return $this->island;
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
                return array('value' => "L'\object {$objects['item']->name} n'a pas pu être ajouté car la limite de l'inventaire à été atteint", 'valid' => false);
            }
            else{
                $this->inventory->addItem($objects);
                return array('value' => "L\'object à bien été ajouté", 'valid' => true);
            }
        }
        else{
            $msg = "";
            foreach ($objects as $object => $value) {
                if($this->limitInventory($value['quantity'])){
                    return array('value' => "L'\object {$value['item']->getName()} n'a pas pu être ajouté car la limite de l'inventaire à été atteint", 'valid' => false);
                }
                else{
                    $this->inventory->addItem($value);
                }
            }
            return array('value' => "Les objects ont bien été ajouté", 'valid' => true);
        }
    }

    /**
    * Test limit of Inventory
    *
    * @return boolean
    */
    public function limitInventory($quantity)
    {
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

    /**
    * Launch Bottle in the sea
    *
    * @return boolean
    */
    public function launchBottle($cardinal,$message)
    {
        $bottle = new Bottle();
        $bottle->message = $message;

        //TODO définir ce qu'il y a dans la direction choisi et la durée de visibilité a définir 
    }

    /**
    * Swimming in the return true if success
    *
    * @return boolean
    */
    public function swimming($cardinal)
    {
        //TODO détecter si il y a une île dans cette direction et calcul sa proba selon la distance
    }

    /**
    * Navigate in the return true if success
    *
    * @return boolean
    */
    public function navigate($cardinal)
    {
        //TODO détecter si il y a une île dans cette direction et calcul sa proba selon la distance
    }

    /**
    *   Watch sea and return message
    *
    * @return string
    */
    public function watchSea($position)
    {
        $messages = array(
            0 => "La mer est tranquille",
            1 => "Vous voyez des oiseaux voler",
            2 => "Vous voyez des poissons dans l'eau",
            3 => "Le ciel se couvre",
            4 => "Le vent souffle fort",
            5 => "Une tempête approche",
            6 => "Les vagues sont hautes",
        );
        $this->detectIles(2);
        // TODO faire la condition si on voit le bateau du capitaine
        if(true == false){
            dump("Le bateau du capitaine est la ");
        }
        // TODO faire la condition si on voit un bateau ou une île proche
        else if(true !== true){
            dump("Il y a un bateau dans cette direction ");
        }
        else{
            dump($messages[rand(0,6)]);
        }
    }


    /**
    * Detect îles 
    * @return array
    */
    public function detectIles($distance){
        for ($i=$this->island->getLocalisationX()-$distance; $i <= $this->island->getLocalisationX()+$distance; $i++) { 
            for ($a=$this->island->getLocalisationY()-$distance; $a <= $this->island->getLocalisationY()+$distance ; $a++) {
                if($i == $this->island->getLocalisationX() && $a == $this->island->getLocalisationY()){continue;}
                if(gettype($this->worldgame->getGrid()[$i][$a]) == 'object'){
                    dump($this->worldgame->getGrid()[$i][$a]);
                }
            }
        }
    }
}