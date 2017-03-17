<?php

namespace SD6Production\PopupInfosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SD6Production\PopupInfosBundle\Entity\PopupPinned;
use SD6Production\PopupInfosBundle\Form\PopupPinnedType;

class DefaultController extends Controller
{
  public function indexAction()
  {
    return $this->render('SD6ProductionPopupInfosBundle:Default:index.html.twig');
  }

  public function popupPinnedAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $popupPinned = $em->getRepository('SD6ProductionPopupInfosBundle:PopupPinned')->findOneBy(array('published' => 1));

    $session = $request->getSession();
    $session->set('popupPinned', $popupPinned);

    return $this->render('SD6ProductionPopupInfosBundle:Default:popup-pinned.html.twig', array(
      'popupPinned' => $popupPinned
    ));
  }

  public function createAction(Request $request)
  {
    $popupPinned = new PopupPinned();
    $formPopup = $this->get('form.factory')->create(new PopupPinnedType(), $popupPinned);

    $formPopup->handleRequest($request);

    if ($formPopup->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($popupPinned);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Popup pinned enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionPopupInfosBundle:Default:add.html.twig', array(
      'formPopup' => $formPopup->createView()
    ));
  }

  public function editeAction(Request $request, $idPopup)
  {
    $em = $this->getDoctrine()->getManager();
    $popupPinned = $em->getRepository('SD6ProductionPopupInfosBundle:PopupPinned')->findOneById($idPopup);

    if(!$idPopup || !$popupPinned) {
      throw $this->createNotFoundException("La popup $idPopup n'existe pas.");
    }

    $formPopup = $this->get('form.factory')->create(new PopupPinnedType(), $popupPinned);

    $formPopup->handleRequest($request);

    if ($formPopup->isValid()) {
      $em->persist($popupPinned);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Popup pinned enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionPopupInfosBundle:Default:add.html.twig', array(
      'formPopup' => $formPopup->createView()
    ));
  }

  public function deleteAction(Request $request, $idPopup)
  {
    $em = $this->getDoctrine()->getManager();
    $popupPinned = $em->getRepository('SD6ProductionPopupInfosBundle:PopupPinned')->findOneById($idPopup);

    if(!$idPopup || !$popupPinned) {
      throw $this->createNotFoundException("La popup $idPopup n'existe pas.");
    }


    $em->remove($popupPinned);
    $em->flush();

    $request->getSession()->getFlashBag()->add('succes', 'Popup pinned supprimée.');


    return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
  }

  public function allAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $allPopup = $em->getRepository('SD6ProductionPopupInfosBundle:PopupPinned')->findAll();


    return $this->render('SD6ProductionPopupInfosBundle:Default:all.html.twig', array(
      'allPopup' => $allPopup
    ));
  }
}
