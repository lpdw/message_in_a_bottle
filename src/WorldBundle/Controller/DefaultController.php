<?php

namespace WorldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {


        if( $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $player = $user->getPlayers()->last();
            var_dump($player);
            if($player){
                $island = $player->getIsland();                
            }
            else{
                return $this->redirect('/worldgame');
            }
            

            return $this->render('island/show.html.twig', array(
                'island' => $island,
            ));
        }
        else {
            return $this->redirect('/login');
        }
    }
}
