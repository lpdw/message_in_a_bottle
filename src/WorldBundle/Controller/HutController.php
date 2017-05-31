<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Hut;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hut controller.
 *
 * @Route("hut")
 */
class HutController extends Controller
{


    /**
     * Finds and displays a hut entity.
     *
     * @Route("/{id}", name="hut_show")
     * @Method("GET")
     */
    public function showAction(Hut $hut)
    {
        return $this->render('hut/show.html.twig', array(
            'hut' => $hut,
        ));
    }

    /**
     * Displays chest content.
     *
     * @Route(name="chest_show")
     * @Method("GET")
     */
    public function chestAction()
    {

        return $this->render('hut/chest.html.twig', array(

        ));
    }

}
