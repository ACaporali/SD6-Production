<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Member;
use SD6Production\AppBundle\Form\MemberType;
use Symfony\Component\HttpFoundation\Response;


class MemberController extends Controller
{
  public function memberAction()
  {
    //Récupère tous les members
    $em = $this->getDoctrine()->getManager();

    $members = $em->getRepository('SD6ProductionAppBundle:Member')->findAll();

    if(empty($members)){
      throw new NotFoundHttpException("Oups, not found team members.");
    }

    return $this->render('SD6ProductionAdminBundle:Member:membre.html.twig', array(
      'members' => $members,
    ));
  }

  /*Ajouter member*/
  public function addAction(Request $request){
    $member = new Member();
    $formMember = $this->get('form.factory')->create(new MemberType(), $member);

    $formMember->handleRequest($request);

    if ($formMember->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($member);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Membre enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_member_index'));

    }

    return $this->render('SD6ProductionAdminBundle:Member:ajouter.html.twig', array(
      'formMember' => $formMember->createView(),
    ));
  }

  /*Editer member*/
  public function editeAction(Request $request, $idMember)
  {
    $em = $this->getDoctrine()->getManager();
    $member = $em->getRepository('SD6ProductionAppBundle:Member')->findOneById($idMember);

    if(!isset($idMember) || empty($member)){
      throw new NotFoundHttpException("Oups, not found member #".$idMember);
    }

    $formMember = $this->get('form.factory')->create(new MemberType(), $member);
    $formMember->handleRequest($request);

    if ($formMember->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($member);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Membre modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_member_index'));
    }

    return $this->render('SD6ProductionAdminBundle:Member:editer.html.twig', array(
      'formMember' => $formMember->createView(),
      'member' => $member,
    ));
  }

  /*Supprimer un member*/
  public function deleteAction($idMember, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $member = $em->getRepository('SD6ProductionAppBundle:Member')->find($idMember);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if(!isset($idMember) || empty($member)){
      throw new NotFoundHttpException("Oups, not found member #".$idMember);
    }else{
      $em->remove($member);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return new Response();
    }
  }
}
