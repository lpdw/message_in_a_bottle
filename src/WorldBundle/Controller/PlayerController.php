<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Player;
use WorldBundle\Entity\Item;
use WorldBundle\Entity\Bottle;
use WorldBundle\Entity\WorldGame;
use WorldBundle\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Player controller.
 *
 * @Route("player")
 */
class PlayerController extends Controller
{
	/**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        $WorldGame = $this->getDoctrine()->getRepository('WorldBundle:WorldGame')->findOneById(3);
        $Island = $this->getDoctrine()->getRepository('WorldBundle:Island')->findOneById(5);
        $Player = $this->getDoctrine()->getRepository('WorldBundle:Player')->findOneById(2);
        // dump($WorldGame);
        // $player = new Player();
        // $player->setName("Kangoo");
        // $player->setStatus("Alive");
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($player);
        // $em->flush($player);

        // dump($Island);
        // $Island->addPlayer($Player);
        // $em->persist($Player);
        // $em->flush($Player);
        // Test Add object in inventory
        // $item1 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(1);
        // $item2 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(2);
        // $item3 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(3);
        // $objects = array();
        // $objects[] = array('item' => $item1, 'quantity' => 25);
        // $objects[] = array('item' => $item2, 'quantity' => 35);
        // $objects[] = array('item' => $item3, 'quantity' => 15);
        // $this->addObjectsAction($objects, $player);
        // dump($player->randomisTrue(50));
        // dump($Player);





        // Test look sea
        // dump($Player->watchSea(15));

        // Test send bottle
        // dump($Player->launchBottle("NORD OUEST","Je suis en bas "));

        // Test swimming
        // dump($Player->swimming("SUD EST"));

        // Test navigate
        // dump($Player->navigate("SUD"));
        dump($Player);
    	die();
        return $this->render('WorldBundle:Default:index.html.twig');
    }

    /**
     * @Route("/addObjects", name="addObjects")
     */
    public function addObjectsAction($objects=null)
    {
        $Player = $this->getDoctrine()->getRepository('WorldBundle:Player')->findOneById(2);
        // Test Add object in inventory
        // $item1 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(1);
        // $item2 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(2);
        // $item3 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(3);
        // $objects = array();
        // $objects[] = array('item' => $item1, 'quantity' => 25);
        // $objects[] = array('item' => $item2, 'quantity' => 10);
        // $objects[] = array('item' => $item3, 'quantity' => 15);


    	$retour = $Player->PickObject($objects);
        // Save object
        $em = $this->getDoctrine()->getManager();
        $em->persist($Player->getInventory());
        $em->flush($Player->getInventory());
        dump($retour['value']);
        dump($Player->getInventory());
        die();
    }

    /**
     * @Route("/moveInIsland", name="moveInIsland")
     */
    public function moveInIslandAction($type = 'swimming',$direction = "NORD EST")
    {
        $Player = $this->getDoctrine()->getRepository('WorldBundle:Player')->findOneById(2);
        if($Player->$type($direction)){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Player);
            $em->flush($Player);
            dump('Arriver sur une île');
        }
        else{dump('retour a la case depart');}
        die();
    }


    /**
     * @Route("/launchBottle", name="launchBottle")
     */
    public function launchBottleAction($direction = "NORD OUEST",$message = "I'M ALIVE")
    {
        $Player = $this->getDoctrine()->getRepository('WorldBundle:Player')->findOneById(2);
        $bottle = $Player->launchBottle($direction,$message);
        if($bottle){
            $beach = $Player->getIsland()->getBeach();
            $beach->addDrop($bottle);
            $em = $this->getDoctrine()->getManager();
            $em->persist($beach);
            $em->flush($beach);
            dump('La bouteille est arrivée sur l\'ile');
        }
        else{dump('Elle n\'est pas arrivée');}
        die();
    }

    /**
     * @Route("/watchSea", name="watchSea", options={"expose"=true})
	 * Method("POST")
	 *
     */
    public function watchSeaAction()
    {
		$user = $this->get('security.token_storage')->getToken()->getUser();
        $player = $user->getPlayers()->last();

        return new Response(json_encode($player->watchSea(3)));
    }

    /**
     * @Route("/item/new", name="new_item")
     */
    public function newItemAction(Request $request)
    {

        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $item->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // instead of its contents
            $item->setImage($fileName);

            // ... persist the $item variable or any other work
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush($item);
            return $this->redirect($this->generateUrl('test'));
        }

        return $this->render('WorldBundle:Item:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }





// ICI : ajout de l'item récupéré dans la foret ou bien ailleur si possible

		/**
		 * @Route("/takeitem/{itemName}", name="takeitem", options={"expose"=true})
		 * @Method("POST")
		 */
		 public function takeItemAction($itemName) {

				$em = $this->getDoctrine()->getManager();

				$item = $em->getRepository('WorldBundle:Item')->findByName($itemName)[0];
				$this->addFlash('test', $item);
				// var_dump($item); die();

				$user = $this->get('security.token_storage')->getToken()->getUser();
				$player = $user->getPlayers()->last();


				$arrayItem = array("quantity"=>1, "item" => $item);
				// $arrayItemu = json_encode($arrayItem);

				$player->getInventory()->addItem($arrayItem);

				$em->persist($player);

				$em->flush();

				return new Response(201);
		 }


}
