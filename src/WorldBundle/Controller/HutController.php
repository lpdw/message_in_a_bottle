<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Hut;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Hut controller.
 *
 * @Route("hut")
 */
class HutController extends Controller
{
    /**
     * Lists all hut entities.
     *
     * @Route("/", name="hut_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $huts = $em->getRepository('WorldBundle:Hut')->findAll();

        return $this->render('hut/index.html.twig', array(
            'huts' => $huts,
        ));
    }

    /**
     * Creates a new hut entity.
     *
     * @Route("/new", name="hut_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hut = new Hut();
        $form = $this->createForm('WorldBundle\Form\HutType', $hut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hut);
            $em->flush();

            return $this->redirectToRoute('hut_show', array('id' => $hut->getId()));
        }

        return $this->render('hut/new.html.twig', array(
            'hut' => $hut,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hut entity.
     *
     * @Route("/{id}", name="hut_show")
     * @Method("GET")
     */
    public function showAction(Hut $hut)
    {
        $deleteForm = $this->createDeleteForm($hut);

        return $this->render('hut/show.html.twig', array(
            'hut' => $hut,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hut entity.
     *
     * @Route("/{id}/edit", name="hut_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hut $hut)
    {
        $deleteForm = $this->createDeleteForm($hut);
        $editForm = $this->createForm('WorldBundle\Form\HutType', $hut);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hut_edit', array('id' => $hut->getId()));
        }

        return $this->render('hut/edit.html.twig', array(
            'hut' => $hut,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hut entity.
     *
     * @Route("/{id}", name="hut_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hut $hut)
    {
        $form = $this->createDeleteForm($hut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hut);
            $em->flush();
        }

        return $this->redirectToRoute('hut_index');
    }

    /**
     * Creates a form to delete a hut entity.
     *
     * @param Hut $hut The hut entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hut $hut)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hut_delete', array('id' => $hut->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
