<?php

namespace SD6Production\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SD6Production\AppBundle\Entity\Annonce;
use SD6Production\AppBundle\Form\AnnonceType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function addannonceAction(Request $request){
    	$annonce = new Annonce();
	    $form = $this->get('form.factory')->create(new AnnonceType(), $annonce);

	    $form->handleRequest($request);

	    if ($form->isValid()) {
	      	$em = $this->getDoctrine()->getManager();
	      	$em->persist($annonce);
	      	$em->flush();

	      	$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      	return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
	    }

	    return $this->render('SD6ProductionAppBundle:Default:add.html.twig', array(
	      'form' => $form->createView(),
	      'type' => 'annonce',
	    ));
    }

    public function editerAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function supprimerAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }
}
