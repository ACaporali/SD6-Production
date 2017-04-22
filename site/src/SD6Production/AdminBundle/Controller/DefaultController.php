<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Advert;
use SD6Production\AppBundle\Form\AdvertType;
use SD6Production\AppBundle\Entity\Member;
use SD6Production\AppBundle\Form\MemberType;
use SD6Production\AppBundle\Entity\Category;
use SD6Production\AppBundle\Form\CategoryType;
use SD6Production\AppBundle\Entity\Image;
use SD6Production\AppBundle\Form\ImageType;

class DefaultController extends Controller
{
  /*Ajouter un element : advert, image, member et category*/
  public function addAction(Request $request){
    $advert = new Advert();
    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);

    $member = new Member();
    $formMember = $this->get('form.factory')->create(new MemberType(), $member);

    $category = new Category();
    $formCategory = $this->get('form.factory')->create(new CategoryType(), $category);

    $image = new Image();
    $formImage = $this->get('form.factory')->create(new ImageType(), $image);

    $formAdvert->handleRequest($request);
    $formMember->handleRequest($request);
    $formCategory->handleRequest($request);
    $formImage->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Advert enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    } else if ($formMember->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($member);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Member enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }else if ($formCategory->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Catégorie enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }else if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Default:ajouter.html.twig', array(
      'formAdvert' => $formAdvert->createView(),
      'formMember' => $formMember->createView(),
      'formCategory' => $formCategory->createView(),
      'formImage' => $formImage->createView(),
    ));
  }

  /*Editer et supprimer advert*/
  public function editeAdvertAction(Request $request, $slugAdvert)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('SD6ProductionAppBundle:Advert')->findOneBySlug($slugAdvert);

    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);
    $formAdvert->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Default:editer.html.twig', array(
      'formAdvert' => $formAdvert->createView(),
      'advert' => $advert,
    ));
  }

  /*Editer image*/
  public function editeImageAction(Request $request, $idImage)
  {
    $em = $this->getDoctrine()->getManager();
    $image = $em->getRepository('SD6ProductionAppBundle:Image')->findOneById($idImage);

    $formImage = $this->get('form.factory')->create(new ImageType(), $image);
    $formImage->handleRequest($request);

    if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Default:editer.html.twig', array(
      'formImage' => $formImage->createView(),
      'image' => $image,
    ));
  }


  /*Editer member*/
  public function editeMemberAction(Request $request, $idMember)
  {
    $em = $this->getDoctrine()->getManager();
    $member = $em->getRepository('SD6ProductionAppBundle:Member')->findOneById($idMember);

    $formMember = $this->get('form.factory')->create(new MemberType(), $member);
    $formMember->handleRequest($request);

    if ($formMember->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($member);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Member modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Default:editer.html.twig', array(
      'formMember' => $formMember->createView(),
      'member' => $member,
    ));
  }


  /*Editer category*/
  public function editeCategoryAction(Request $request, $idCategory)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository('SD6ProductionAppBundle:Category')->findOneById($idCategory);

    $formCategory = $this->get('form.factory')->create(new CategoryType(), $category);
    $formCategory->handleRequest($request);

    if ($formCategory->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Category modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Default:editer.html.twig', array(
      'formCategory' => $formCategory->createView(),
      'category' => $category,
    ));
  }

  /*Supprimer un element : advert, image, member ou category*/
  public function deleteAction($typeElement, $numElement, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    //Regarde le type d'Entity à supprimer
    if ($typeElement == 'advert') {
      $elementDelete = $em->getRepository('SD6ProductionAppBundle:Advert')->find($numElement);
    }elseif ($typeElement == 'equipe') {
      $elementDelete = $em->getRepository('SD6ProductionAppBundle:Member')->find($numElement);
    }elseif ($typeElement == 'image') {
      $elementDelete = $em->getRepository('SD6ProductionAppBundle:Image')->find($numElement);
    }elseif ($typeElement == 'category') {
      $elementDelete = $em->getRepository('SD6ProductionAppBundle:Category')->find($numElement);
    }

    $session = $request->getSession();
    $session->set('numero', $numElement);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($elementDelete === null) {
      throw new NotFoundHttpException("Element d'id ".$numElement." n'existe pas.");
    }else{
      $em->remove($elementDelete);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }

  public function categoryAction()
  {
    //Récupère toutes les catégories
    $em = $this->getDoctrine()->getManager();

    $listeCategories = $em->getRepository('SD6ProductionAppBundle:Category')->findAll();

    return $this->render('SD6ProductionAdminBundle:Default:categorie.html.twig', array(
      'listeCategories' => $listeCategories,
    ));
  }
}
