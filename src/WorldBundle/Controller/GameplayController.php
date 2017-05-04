<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\WorldGame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Gameplay controller.
 *
 * @Route("gameplay")
 */
class GameplayController extends Controller
{

    /**
    * When a user wants to join a worldgame
    * @Route("/joinworldgame/{id}", name="joinworldgame")
    * @Method("GET")
    */
    public function joinWorldAction(WorldGame $worldGame) {
        dump($worldGame);
        die();

        // creating a new played linked to the user
        // sending the player to an island
    }

}
