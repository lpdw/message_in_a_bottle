<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Island;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Island controller.
 *
 * @Route("island")
 */
class IslandController extends Controller
{
    /**
     * Lists all island entities.
     *
     * @Route("/", name="island_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $islands = $em->getRepository('WorldBundle:Island')->findAll();

        return $this->render('island/index.html.twig', array(
            'islands' => $islands,
        ));
    }

    /**
     * Finds and displays a island entity.
     *
     * @Route("/{id}", name="island_show")
     * @Method("GET")
     */
    public function showAction(Island $island)
    {

        return $this->render('island/show.html.twig', array(
            'island' => $island,
        ));
    }
}
