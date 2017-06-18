<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Category;
use SD6Production\AppBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
  public function categoryAction()
  {
    //Récupère toutes les catégories
    $em = $this->getDoctrine()->getManager();

    $listeCategories = $em->getRepository('SD6ProductionAppBundle:Category')->findAll();

    return $this->render('SD6ProductionAdminBundle:Category:categorie.html.twig', array(
      'listeCategories' => $listeCategories,
    ));
  }

  /*Ajouter category*/
  public function addAction(Request $request){
    $category = new Category();
    $formCategory = $this->get('form.factory')->create(new CategoryType(), $category);

    $formCategory->handleRequest($request);

    if ($formCategory->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Catégorie enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_category_index'));

    }

    return $this->render('SD6ProductionAdminBundle:Category:ajouter.html.twig', array(
      'formCategory' => $formCategory->createView(),
    ));
  }

  /*Editer category*/
  public function editeAction(Request $request, $idCategory)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository('SD6ProductionAppBundle:Category')->findOneById($idCategory);

    $formCategory = $this->get('form.factory')->create(new CategoryType(), $category);
    $formCategory->handleRequest($request);

    if ($formCategory->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Categorie modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_category_index'));
    }

    return $this->render('SD6ProductionAdminBundle:Category:editer.html.twig', array(
      'formCategory' => $formCategory->createView(),
      'category' => $category,
    ));
  }

  /*Supprimer une category*/
  public function deleteAction($idCategory, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $category = $em->getRepository('SD6ProductionAppBundle:Category')->find($idCategory);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($idCategory === null) {
      throw new NotFoundHttpException("Element d'id ".$idCategory." n'existe pas.");
    }else{
      $em->remove($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return new Response();
    }
  }
}
