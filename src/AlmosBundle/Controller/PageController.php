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
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('almos.emails.contact_email'))
                    ->setBody($this->renderView('AlmosBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add(
                    'blogger-notice',
                    'Ваш запрос успешно отправлен. Спасибо!');

                // Редирект - это важно для предотвращения повторного ввода данных в форму,
                // если пользователь обновил страницу.
                return $this->redirect($this->generateUrl('AlmosBundle_contact'));
            }
        }

            return $this->render('AlmosBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}