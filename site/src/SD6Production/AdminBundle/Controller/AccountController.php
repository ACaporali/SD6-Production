<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Category;
use SD6Production\AppBundle\Form\CategoryType;


class AccountController extends Controller
{
  public function accountAction()
  {
    //Récupère toutes les catégories
    $em = $this->get('fos_user.user_manager');
    $users = $em->findUsers();

    $userConnected = $this->get('security.token_storage')->getToken()->getUser();

    return $this->render('SD6ProductionAdminBundle:Account:account.html.twig', array(
      'users' => $users,
      'userConnected' => $userConnected
    ));
  }
  
  /*Supprimer une account*/
  public function deleteAction($numAccount, Request $request)
  {
    $em = $this->get('fos_user.user_manager');
    $account = $em->findUserBy(array('id'=>$numAccount));

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($numAccount === null) {
      throw new NotFoundHttpException("Element d'id ".$numAccount." n'existe pas.");
    }else{
      $em->deleteUser($account);

      $request->getSession()->getFlashBag()->add('succes', 'Compte '.$account->getEmail().' supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }
}