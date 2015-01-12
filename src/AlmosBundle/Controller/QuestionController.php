<?php


namespace AlmosBundle\Controller;

use AlmosBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Question controller.
 */

class QuestionController extends Controller
{
    /**
     * Show a question entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AlmosBundle:Question')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository('AlmosBundle:Comment')
            ->getCommentsForBlog($blog->getId());

        return $this->render('AlmosBundle:Question:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }

    /**
     * Creates a new Blog entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Question();
        $form = $this->createForm(new EnquiryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();
        }
    }

    public function uploadAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createFormBuilder($blog)
            ->add('name')
            ->add('file')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl());
        }

        return array('form' => $form->createView());
    }

}