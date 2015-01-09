<?php

namespace AlmosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AlmosBundle\Entity\Comment;
use AlmosBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    public function newAction($question_id )
    {
        $blog = $this->getBlog($question_id);

        $comment = new Comment();
        $comment->setComment($blog);
        $form   = $this->createForm(new CommentType(), $comment);

        return $this->render('AlmosBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    public function createAction($question_id )
    {
        $blog = $this->getBlog($question_id );

        $comment  = new Comment();
        $comment->setComment($blog);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->Bind($request);

        if ($form->isValid()) {
            // TODO: Persist the comment entity

            return $this->redirect($this->generateUrl('AlmosBundle_question_show', array(
                    'id' => $comment->getComment())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('AlmosBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($question_id  )
    {
        $em = $this->getDoctrine()
            ->getManager();

        $blog = $em->getRepository('AlmosBundle:Question')->find($question_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}