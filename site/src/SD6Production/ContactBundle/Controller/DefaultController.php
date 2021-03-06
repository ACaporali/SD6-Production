<?php

namespace SD6Production\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SD6Production\ContactBundle\Entity\Contact;
use SD6Production\ContactBundle\Form\ContactType;

class DefaultController extends Controller
{
  public function contactAction(Request $request)
  {
    $contact = new Contact();
    $form = $this->createForm(new ContactType(), $contact);

    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
      $form->handleRequest($request);

      if ($form->isValid()) {
        $message = \Swift_Message::newInstance()
        ->setSubject('Mail du site SD6 Production')
        ->setFrom('send@hotmail.fr')
        ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
        ->setBody($this->renderView('SD6ProductionContactBundle:Default:gabaritMail.txt.twig', array('contact' => $contact)));
        $this->get('mailer')->send($message);

        $request->getSession()->getFlashBag()->add('succes', 'Message envoyé avec succès ! Merci.');

        return $this->redirect($this->generateUrl('sd6_production_contact_contact'));
      }
    }

    return $this->render('SD6ProductionContactBundle:Default:contact.html.twig', array(
      'form' => $form->createView()
    ));
  }
}
