<?php



namespace AlmosBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AlmosBundle\Entity\Enquiry;
use AlmosBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $questions = $em->getRepository('AlmosBundle:Question')
            ->getLatestQuestion();

        return $this->render('AlmosBundle:Page:index.html.twig', array(
            'questions' => $questions
        ));
    }

    public function aboutAction()
    {
        return $this->render('AlmosBundle:Page:about.html.twig');
    }

    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $this->get('my_mailer')->Send('Contact enquiry from symblog', 'enquiries@symblog.co.uk', 'alexmoss@gmail.com',
                    $this->renderView('AlmosBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)) ,$this->get('mailer')
                    );

              //  $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add(
                    'blogger-notice',
                    'Your contact enquiry was successfully sent. Thank you!');

                // Редирект - это важно для предотвращения повторного ввода данных в форму,
                // если пользователь обновил страницу.
                return $this->redirect($this->generateUrl('AlmosBundle_contact'));

            }
        }

            return $this->render('AlmosBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $tags = $em->getRepository('AlmosBundle:Question')
            ->getTags();

        $tagWeights = $em->getRepository('AlmosBundle:Question')
            ->getTagWeights($tags);

        $commentLimit   = $this->container
            ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('AlmosBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('AlmosBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags' => $tagWeights
        ));

    }

    public function changeLanguageAction()
    {
        $language = $this->getRequest()->get('language');
        return $this->redirect($this->generateUrl('AlmosBundle_homepage', array('_locale' => $language)));
    }

}