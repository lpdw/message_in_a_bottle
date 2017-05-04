<?php

namespace WorldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameplayControllerController extends Controller
{
    /**
     * @Route("/joinWorldGame")
     */
    public function joinWorldGameAction()
    {
        return $this->render('WorldBundle:GameplayController:join_world_game.html.twig', array(
            
        ));
    }

}
