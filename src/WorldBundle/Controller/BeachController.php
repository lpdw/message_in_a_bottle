<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Beach;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Beach controller.
 *
 * @Route("beach")
 */
class BeachController extends Controller
{
    /**
     * Lists all beach entities.
     *
     * @Route("/", name="beach_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $beaches = $em->getRepository('WorldBundle:Beach')->findAll();

        return $this->render('beach/index.html.twig', array(
            'beaches' => $beaches,
        ));
    }

    /**
     * Finds and displays a beach entity.
     *
     * @Route("/{id}", name="beach_show")
     * @Method("GET")
     */
    public function showAction(Beach $beach)
    {

        return $this->render('beach/show.html.twig', array(
            'beach' => $beach,
        ));
    }
}
