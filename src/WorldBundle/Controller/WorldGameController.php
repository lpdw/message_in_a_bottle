<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\WorldGame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Worldgame controller.
 *
 * @Route("worldgame")
 */
class WorldGameController extends Controller
{
    /**
     * Lists all worldGame entities.
     *
     * @Route("/", name="worldgame_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $worldGames = $em->getRepository('WorldBundle:WorldGame')->findAll();

        return $this->render('worldgame/index.html.twig', array(
            'worldGames' => $worldGames,
        ));
    }

    /**
     * Creates a new worldGame entity.
     *
     * @Route("/new", name="worldgame_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $worldGame = new Worldgame();

        $form = $this->createForm('WorldBundle\Form\WorldGameType', $worldGame);
        $form->handleRequest($request);

        // Generating the world
        $nbPlayers = 5;
        $nbIslands = 5*3;

        // Creating an empty grid
        $gridGame = array();
        for ($i=0; $i < $nbIslands ; $i++) {
            $gridGame[$i] = array_fill(0, $nbIslands, null);
        }
        $worldGame->setGrid($gridGame);

        // Generating the islands
        $island = new Island();

        // Placing the islands on the grid

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($worldGame);
            $em->flush();

            return $this->redirectToRoute('worldgame_show', array('id' => $worldGame->getId()));
        }

        return $this->render('worldgame/new.html.twig', array(
            'worldGame' => $worldGame,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a worldGame entity.
     *
     * @Route("/{id}", name="worldgame_show")
     * @Method("GET")
     */
    public function showAction(WorldGame $worldGame)
    {
        $deleteForm = $this->createDeleteForm($worldGame);

        return $this->render('worldgame/show.html.twig', array(
            'worldGame' => $worldGame,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing worldGame entity.
     *
     * @Route("/{id}/edit", name="worldgame_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, WorldGame $worldGame)
    {
        $deleteForm = $this->createDeleteForm($worldGame);
        $editForm = $this->createForm('WorldBundle\Form\WorldGameType', $worldGame);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('worldgame_edit', array('id' => $worldGame->getId()));
        }

        return $this->render('worldgame/edit.html.twig', array(
            'worldGame' => $worldGame,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a worldGame entity.
     *
     * @Route("/{id}", name="worldgame_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, WorldGame $worldGame)
    {
        $form = $this->createDeleteForm($worldGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($worldGame);
            $em->flush();
        }

        return $this->redirectToRoute('worldgame_index');
    }

    /**
     * Creates a form to delete a worldGame entity.
     *
     * @param WorldGame $worldGame The worldGame entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WorldGame $worldGame)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('worldgame_delete', array('id' => $worldGame->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
