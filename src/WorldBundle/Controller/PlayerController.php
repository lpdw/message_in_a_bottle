<?php

namespace WorldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WorldBundle\Entity\Player;
use WorldBundle\Entity\Item;
use WorldBundle\Form\ItemType;

class PlayerController extends Controller
{
	/**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
    	$player = new Player();
    	$item1 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(1);
    	$item2 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(2);
    	$item3 = $this->getDoctrine()->getRepository('WorldBundle:Item')->findOneById(3);
    	$objects = array();
    	$objects[] = array('item' => $item1, 'quantity' => 25);
    	$objects[] = array('item' => $item2, 'quantity' => 35);
    	$objects[] = array('item' => $item3, 'quantity' => 15);
    	$this->addObjectsAction($objects, $player);
    	// dump($player->randomisTrue(50));
    	die();
        return $this->render('WorldBundle:Default:index.html.twig');
    }

    /**
     * @Route("/addObjects", name="addObjects")
     */
    public function addObjectsAction($objects, $player)
    {
    	dump($player->PickObject($objects));
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
}
