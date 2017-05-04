<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Forest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Forest controller.
 *
 * @Route("forest")
 */
class ForestController extends Controller
{
    /**
     * Lists all forest entities.
     *
     * @Route("/", name="forest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $forests = $em->getRepository('WorldBundle:Forest')->findAll();

        return $this->render('forest/index.html.twig', array(
            'forests' => $forests,
        ));
    }

    /**
     * Creates a new forest entity.
     *
     * @Route("/new", name="forest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $forest = new Forest();
        $form = $this->createForm('WorldBundle\Form\ForestType', $forest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forest);
            $em->flush();

            return $this->redirectToRoute('forest_show', array('id' => $forest->getId()));
        }

        return $this->render('forest/new.html.twig', array(
            'forest' => $forest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a forest entity.
     *
     * @Route("/{id}", name="forest_show")
     * @Method("GET")
     */
    public function showAction(Forest $forest)
    {
        $deleteForm = $this->createDeleteForm($forest);

        return $this->render('forest/show.html.twig', array(
            'forest' => $forest,
            'delete_form' => $deleteForm->createView(),
        ));
    }
        /**
     * return json file.
     *
     * @Route("/json/{name}")
     * @Method("GET")
     */
    public function jsonAction($name)
    {
        echo "Name :".$name;
        die();
        return 'toto';
    }

    /**
     * Displays a form to edit an existing forest entity.
     *
     * @Route("/{id}/edit", name="forest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Forest $forest)
    {
        $deleteForm = $this->createDeleteForm($forest);
        $editForm = $this->createForm('WorldBundle\Form\ForestType', $forest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('forest_edit', array('id' => $forest->getId()));
        }

        return $this->render('forest/edit.html.twig', array(
            'forest' => $forest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a forest entity.
     *
     * @Route("/{id}", name="forest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Forest $forest)
    {
        $form = $this->createDeleteForm($forest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forest);
            $em->flush();
        }

        return $this->redirectToRoute('forest_index');
    }

    /**
     * Creates a form to delete a forest entity.
     *
     * @param Forest $forest The forest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Forest $forest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forest_delete', array('id' => $forest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
