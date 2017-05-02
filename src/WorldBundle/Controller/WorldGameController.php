<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\WorldGame;
use WorldBundle\Entity\Island;
use WorldBundle\Entity\Forest;
use WorldBundle\Entity\Beach;
use WorldBundle\Entity\Hut;
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
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('WorldBundle\Form\WorldGameType', $worldGame);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // Generating the world
            $nbPlayers = 5;
            $nbIslands = $nbPlayers*3;

            // Creating an empty grid
            $gridGame = array();
            for ($i=0; $i < $nbIslands ; $i++) {
                $gridGame[$i] = array_fill(0, $nbIslands, null);
            }


            // Generating the islands
            $j = 0;
            while ($j <= $nbIslands-1) {
                // Placing the islands on the grid
                $island = new Island();


                $forest = new Forest();
                $forest->setIsland($island);
                $island->setForest($forest);

                $beach = new Beach();
                $beach->setIsland($island);
                $island->setBeach($beach);

                $hut = new Hut();
                $hut->setIsland($island);
                $island->setHut($hut);


                $islandIsPlaced = false;

                while(!$islandIsPlaced) {
                    // choosing a random position on the grid
                    $randomX = random_int(0, $nbIslands-1);
                    $randomY = random_int(0, $nbIslands-1);

                    // verifiyng that the position is empty
                    $currentPosition = $gridGame[$randomX][$randomY];

                    if (!$currentPosition) {
                        $gridGame[$randomX][$randomY] = $island; // TODO : identify the island

                        // TODO : fill near positions
                        if ($randomX+1 <= $nbIslands) {
                            $gridGame[$randomX+1][$randomY] = "coast";

                            if($randomY+1 <= $nbIslands) {
                                $gridGame[$randomX+1][$randomY+1] = "coast";
                            }

                            if ($randomY-1 >= 0) {
                                $gridGame[$randomX+1][$randomY-1] = "coast";

                            }
                        }

                        if ($randomX-1 >= 0) {
                            $gridGame[$randomX-1][$randomY] = "coast";

                            if ($randomY+1 <= $nbIslands) {
                                $gridGame[$randomX-1][$randomY+1] = "coast";
                            }

                            if($randomY-1 >= 0) {
                                $gridGame[$randomX-1][$randomY-1] = "coast";
                            }
                        }

                        if ($randomY+1 <= $nbIslands) {
                            $gridGame[$randomX][$randomY+1] = "coast";
                        }

                        if ($randomY-1 >= 0) {
                            $gridGame[$randomX][$randomY-1] = "coast";
                        }



                        // TODO : set type
                        $island->setWorldgame($worldGame);
                        $island->setType("playertype");
                        // set the island coordinates
                        $island->setLocalisationX($randomX);
                        $island->setLocalisationY($randomY);

                        $islandIsPlaced = true;
                    }

                }

                // updating the grid
                $worldGame->setGrid($gridGame);

                $em->persist($island);

                $j++;
            }

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
