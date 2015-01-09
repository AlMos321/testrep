<?php


namespace AlmosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Question controller.
 */

class QuestionController extends Controller
{
    /**
     * Show a question entry
     */
    public function showAction($id)
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
}