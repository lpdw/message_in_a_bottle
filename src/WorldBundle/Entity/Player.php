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
        $bottle->setMessage($message);
        
        $island = $this->findIsland($cardinal)['data'];

        return (!$island) ? false: true;
    }

    /**
    * Swimming for another island
    *
    * @return boolean
    */
    public function swimming($cardinal)
    {
        $island = $this->findIsland($cardinal);
        if(!$island['data']){return false;}
        else{
            $percent = 50 - (int)($island['distance']*10);
            if($percent <= 0){return false;}
            $resultat = $this->randomisTrue($percent);
            if($resultat){$this->island = $island['data'];}            
            return $resultat;
        }
    }

    /**
    * Navigate for another island
    *
    * @return boolean
    */
    public function navigate($cardinal)
    {
        $island = $this->findIsland($cardinal);
        if(!$island['data']){return false;}
        else{
            $percent = 100 - (int)(($island['distance']/3)*10);
            if($percent <= 0){return false;}
            $resultat = $this->randomisTrue($percent);
            if($resultat){$this->island = $island['data'];}            
            return $resultat;
        }
    }

    /**
    *   Watch sea and return message
    *
    * @return string/array
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
        $islands = $this->detectIslands(2);
        // TODO faire la condition si on voit le bateau du capitaine
        if(!empty($islands)){
            $msg = array();
            foreach ($islands as $key => $value) {
                $base = "une île";
                if($value['type'] == 'captain'){$base = "l'île du capitaine";}
                $msg[] = "Il y a $base dans la direction {$value['position']} qui se trouve à ".($value['distance']*10)." minutes";
            }
            return $msg;
        }
        else{
            return $messages[rand(0,6)];
        }
    }


    /**
    * Detect îles 
    * @return array
    */
    public function detectIslands($distance){
        $islands = array();
        if($distance == "all"){
            $xStart = $yStart = 0;
            $xEnd = $yEnd = 14;
        }
        else{
            $xStart = ($this->island->getLocalisationX()-$distance < 0) ? 0 :$this->island->getLocalisationX()-$distance;
            $xEnd = ($this->island->getLocalisationX()+$distance > 14) ? 14 : $this->island->getLocalisationX()+$distance;
            $yStart = ($this->island->getLocalisationY()-$distance < 0) ? 0 : $this->island->getLocalisationY()-$distance;
            $yEnd = ($this->island->getLocalisationY()+$distance > 14) ? 14 : $this->island->getLocalisationY()+$distance;            
        } 
        for ($i=$xStart; $i <= $xEnd; $i++) { 
            for ($a=$yStart; $a <= $yEnd; $a++) {
                if($i == $this->island->getLocalisationX() && $a == $this->island->getLocalisationY()){continue;}
                if(gettype($this->island->getWorldgame()->getGrid()[$i][$a]) == 'object'){
                    $pos = $this->directionIsland($this->island->getLocalisationX(),$i,"x");
                    $pos .= (empty($pos))? $this->directionIsland($this->island->getLocalisationY(),$a,"y") : " ".$this->directionIsland($this->island->getLocalisationY(),$a,"y");
                    if(substr($pos, -1) == " "){$pos = trim($pos);}
                    $dist = $this->distanceIslands($this->island->getLocalisationX(),$this->island->getLocalisationY(),$i,$a);
                    $islands[] = array("cardinal"=>$pos,"distance"=>$dist,"type"=>$this->island->getWorldgame()->getGrid()[$i][$a]->getType(),"x"=>$i,"y"=>$a);
                }
            }
        }
        return $islands;
    }

    /**
    * Give the direction of ile
    * @return string
    */
    public function directionIsland($x,$i,$type){
        if($x < $i){return ($type == 'x') ? "SUD" : "EST";}
        else if($x > $i){return ($type == 'x') ? "NORD" : "OUEST";}
        return "";
    }

    /**
    * Give the distance between two îles
    * @return string
    */
    public function distanceIslands($x,$y,$a,$b){
        $x = abs($x - $a);
        $y = abs($y - $b);
        if($x == 0 || $y == 0){return $x+$y;}
        else{return ($x+$y)/2;}
    }

    /**
    * Move in world
    * @return array
    */
    public function moveinWorld($position,$cardinal){
        if(strpos(strtoupper($cardinal),"NORD")){$position['x']--;}
        else if (strpos(strtoupper($cardinal),"SUD")){$position['x']++;}

        if(strpos(strtoupper($cardinal),"EST")){$position['y']++;}
        else if (strpos(strtoupper($cardinal),"OUEST")){$position['y']--;}
        return $position;
    }

    /**
    * Find ile
    * @return island
    */
    public function findIsland($cardinal){
        $island = $this->isIsland($cardinal);
        if($island["x"] == -1 || $island["y"] == -1){return false;}
        else{return array("data"=>$this->island->getWorldgame()->getGrid()[$island["x"]][$island["y"]],"distance"=>$island['distance']);}
    }


    /**
    * test if is in island
    * @return $position
    */
    public function isIsland($cardinal){
        $position = array("x"=>-1, "y"=>-1, "distance" => 14);
        $islands = $this->detectIslands("all");
        foreach ($islands as $key => $value) {
            if($value["cardinal"] == $cardinal && $value["distance"] < $position['distance']){
                $position['x'] = $value["x"];
                $position['y'] = $value["y"];
                $position['distance'] = $value["distance"];
            }
        }
        return $position;
    }
}