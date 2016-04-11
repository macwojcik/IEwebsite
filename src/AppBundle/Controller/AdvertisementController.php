<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Advertisement;
use AppBundle\Form\AdvertisementType;

/**
 * Advertisement controller.
 *
 */
class AdvertisementController extends Controller
{
    /**
     * Lists all Advertisement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $advertisements = $em->getRepository('AppBundle:Advertisement')->findAll();


        return $this->render('advertisement/index.html.twig', array(
            'advertisements' => $advertisements,
        ));
    }

    /**
     * Creates a new Advertisement entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advertisement = new Advertisement();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $form = $this->createForm(new AdvertisementType(), $advertisement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser()->getId();
            $advertisement->setUserId($user);

            $em->persist($advertisement);
            $em->flush();

            return $this->redirectToRoute('advert', array('id' => $advertisement->getId()));
        }

        return $this->render('advertisement/new.html.twig', array(
            'advertisement' => $advertisement,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Advertisement entity.
     *
     */
    public function showAction(Advertisement $advertisement)
    {
        $deleteForm = $this->createDeleteForm($advertisement);

        return $this->render('advertisement/show.html.twig', array(
            'advertisement' => $advertisement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Advertisement entity.
     *
     */
    public function editAction(Request $request, Advertisement $advertisement)
    {
        $deleteForm = $this->createDeleteForm($advertisement);
        $editForm = $this->createForm(new AdvertisementType(), $advertisement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advertisement);
            $em->flush();

            return $this->redirectToRoute('add_edit', array('id' => $advertisement->getId()));
        }

        return $this->render('advertisement/edit.html.twig', array(
            'advertisement' => $advertisement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Advertisement entity.
     *
     */
    public function deleteAction(Request $request, Advertisement $advertisement)
    {
        $form = $this->createDeleteForm($advertisement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($advertisement);
            $em->flush();
        }

        return $this->redirectToRoute('add_index');
    }

    /**
     * Creates a form to delete a Advertisement entity.
     *
     * @param Advertisement $advertisement The Advertisement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Advertisement $advertisement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('add_delete', array('id' => $advertisement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
