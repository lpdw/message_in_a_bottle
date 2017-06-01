<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\WorldGame;
use WorldBundle\Entity\Hut;
use WorldBundle\Entity\Player;
use WorldBundle\Entity\Inventory;
use WorldBundle\Entity\Item;
use WorldBundle\Entity\Bottle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class GameplayController extends Controller
{

    /**
    * When a user wants to join a worldgame
    * @Route("/joinworldgame/{id}", name="joinworldgame")
    * @Method("GET")
    */
    public function joinWorldAction(WorldGame $worldGame) {
        $em = $this->getDoctrine()->getManager();

        // creating a new player linked to the user
        $player = new Player();
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $currentUser->setIsPlaying(true);
        $player->setName($currentUser->getUsername());
        $player->setStatus("ok");
        $player->setUser($currentUser);

        // placing the player on an sialdn
        // first we get all the deserted player type islands belonging to the current world
        $islands = $em
            ->getRepository('WorldBundle:Island')
            ->findBy(
                array(
                    'worldgame' => $worldGame->getId(),
                    'type' => 'player',
                    'deserted' => true,
                )
            );
        $nbIslands = count($islands);
        $playerIsland = $islands[random_int(0, $nbIslands-1)];
        $player->setIsland($playerIsland);
        $playerIsland->setDeserted(false);

        // giving a starter bottle to player

        $bottle = new Bottle();
        $bottle->setName('bottle');
        $bottle->setDescription('A glassy bottle with a paper in it. Your best friend against solitude.');
        $bottle->setImage('no_image');
        $bottle->setMessage("");
        $em->persist($bottle);

        // $bottle = $em->getRepository('WorldBundle:Bottle')->findBy(array('name'=>'bottle'))[0];
        $bottleObject[] = array(
            "item" => $bottle,
            "quantity"=>1
        );
        $em->persist($player);
        $em->flush();

        $currentUser->addPlayer($player);

        $player->PickObject($bottleObject);
        $em->persist($player);
        $em->flush();


        return $this->render('island/show.html.twig', array(
            'island' => $playerIsland,
        ));

    }


    /**
     * @Route("/putinchest/{id}", name="putinchest", options={"expose"=true})
     * @Method("POST")
     */
     public function putInChestAction(Item $item) {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $player = $user->getPlayers()->last();
        $hut = $player->getIsland()->getHut();
        $inventory = $player->getInventory();

        $hut->addChest($item);
        $inventory->removeItem($item);

        $em->persist($hut);

        $em->flush();

        return new Response(201);
     }

     /**
      * @Route("/takefromchest/{id}", name="takefromchest", options={"expose"=true})
      * @Method("POST")
      */
      public function takeFromChestAction(Item $item) {
         $em = $this->getDoctrine()->getManager();

         $user = $this->get('security.token_storage')->getToken()->getUser();
         $player = $user->getPlayers()->last();
         $hut = $player->getIsland()->getHut();
         $inventory = $player->getInventory();

         $arrayItem = array("item" => $item, "quantity"=>1);
         $this->addFlash("item", $arrayItem);

         $inventory->addItem($arrayItem);
         $hut->removeChest($item);

         $em->persist($hut);

         $em->flush();

         return new Response(201);
      }

      /**
      * @Route("/takebottle/{id}", name="take_bottle")
      * Testy function that just creates a bottle out of litteraly nowhere and add it to the current player's inventory
      * @param id_hut
      */
      public function takeBottle($id) {
          $em = $this->getDoctrine()->getManager();

          $bottle = new Bottle();
          $bottle->setName('bottle');
          $bottle->setDescription('A glassy bottle with a paper in it. Your best friend against solitude.');
          $bottle->setImage('no_image');
          $bottle->setMessage("");
          $em->persist($bottle);

          $item = array("quantity"=>1, "item"=>$bottle);

          $user = $this->get('security.token_storage')->getToken()->getUser();
          $player = $user->getPlayers()->last();
          $player->getInventory()->addItem($item);
          $em->persist($player);

          $em->flush();

          return $this->redirectToRoute('hut_show', array('id' => $id));

      }

}
