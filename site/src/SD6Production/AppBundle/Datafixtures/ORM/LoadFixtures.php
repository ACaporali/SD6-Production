<?php

namespace SD6Production\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use SD6Production\AppBundle\Entity\Categorie;
use SD6Production\AppBundle\Entity\Annonce;
use SD6Production\AppBundle\Entity\Membre;
use SD6Production\AppBundle\Entity\Image;

class LoadFixtures implements FixtureInterface, ContainerAwareInterface
{
   /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

   public function load(ObjectManager $manager)
   {
      $this->loadCatImageAnnonce($manager);
      $this->loadUtilMembre($manager);
   }

   private function loadCatImageAnnonce(ObjectManager $manager)
   {
      //Creation de catégories
      $names = array(
         'Actualite',
         'Evenement',
         'Production',
         'Recrutement',
         'Galerie'
      );

      foreach ($names as $name) {
         $categorie = new Categorie();
         $categorie->setNom($name);

         $manager->persist($categorie);
      }

      //Création d'une image
      $image = new Image;
      $image->setUrl('uploads/img/image.jpg');
      $manager->persist($image);

      //Création d'annonces
      $annonces = [];
      for ($i=0; $i <20 ; $i++) {
         $annonces[$i] = new Annonce;
         $annonces[$i]->setTitre('L\'article '.$i.'');
         $annonces[$i]->setContenu('Aliquam erat volutpat. Nunc auctor. Mauris pretium quam et urna. Fusce nibh. Duis risus. Curabitur sagittis hendrerit ante. Aliquam erat volutpat. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat.');
         $annonces[$i]->setAuteur('Alice');
         $annonces[$i]->setDate(new \DateTime("now"));
         $annonces[$i]->setPublie(true);
         $annonces[$i]->setCategorie($categorie);
         $annonces[$i]->setImage($image);
         $annonces[$i]->setEpingle(false);
         $manager->persist($annonces[$i]);
      }
      $manager->flush();
   }

   private function loadUtilMembre(ObjectManager $manager)
   {
      //Création d'un utilisateur admin
      $utilManager = $this->container->get('fos_user.user_manager');
      $util = $utilManager->createUser();
      $util->setUsername('admin');
      $util->setEmail('email@domain.com');
      $util->setPlainPassword('admin');
      //$util->setPassword('3NCRYPT3D-V3R51ON');
      $util->setEnabled(true);
      $util->setRoles(array('ROLE_ADMIN'));

      $utilManager->updateUser($util, true);

      //Création d'une image
      $image = new Image;
      $image->setUrl('uploads/img/personne.jpg');
      $manager->persist($image);

      //Création de membres page equipe
      $names = array(
         'Pierre',
         'John',
         'Jeanne',
         'Michelle'
      );

      $poste = 'Assistant techinque';

      $description = 'Iamque lituis cladium concrepantibus internarum non celate ut antea turbidum saeviebat ingenium a veri consideratione detortum et nullo inpositorum vel conpositorum.';

      foreach ($names as $name) {
         $membre = new Membre();
         $membre->setPrenom($name);
         $membre->setPoste($poste);
         $membre->setDescription($description);
         $membre->setImage($image);

         $manager->persist($membre);
      }
      $manager->flush();
   }
}
