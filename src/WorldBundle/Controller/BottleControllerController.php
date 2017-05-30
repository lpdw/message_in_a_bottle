<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Bottle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BottleControllerController extends Controller
{
    /**
     * @Route("/updateMessage/{id}", name="update_bottle_message", options={"expose"=true})
     * Method("POST")
     */
    public function updateMessageAction(Request $request, Bottle $bottle)
    {
        $em = $this->getDoctrine()->getManager();

        $newmessage = $request->request->get('newmessage');
        $bottle->setMessage($newmessage);
        $em->persist($bottle);
        $em->flush();

        return new Response(201);
    }

}
