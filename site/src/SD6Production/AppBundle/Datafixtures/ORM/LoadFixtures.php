<?php

namespace SD6Production\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use SD6Production\AppBundle\Entity\Category;
use SD6Production\AppBundle\Entity\Advert;
use SD6Production\AppBundle\Entity\Member;
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
      $this->loadCatImageAdvert($manager);
      $this->loadUtilMember($manager);
   }

   private function loadCatImageAdvert(ObjectManager $manager)
   {
      //Creation de catégories
      $names = array(
         'Actualites',
         'Evenement',
         'Productions',
         'Casting',
         'Galerie'
      );

      $categories= [];
      foreach ($names as $name) {
         $category = new Category();
         $category->setName($name);

         array_push($categories, $category);
         $manager->persist($category);
      }

      $manager->flush();

      //Création d'une image
      $image = new Image;
      $image->setUrl('uploads/img/image.jpg');
      $manager->persist($image);

      //Création d'adverts
      $adverts = [];
      for ($i=0; $i <20 ; $i++) {
         $adverts[$i] = new Advert;
         $adverts[$i]->setTitle('L\'article '.$i.'');
         $adverts[$i]->setContent('Aliquam erat volutpat. Nunc auctor. Mauris pretium quam et urna. Fusce nibh. Duis risus. Curabitur sagittis hendrerit ante. Aliquam erat volutpat. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat.');
         $adverts[$i]->setAuthor('Alice');
         $adverts[$i]->setDate(new \DateTime("now"));
         $adverts[$i]->setPublished(true);
         $adverts[$i]->setCategory($categories[array_rand($categories)]);
         $adverts[$i]->setImage($image);
         $adverts[$i]->setPinned(false);
         $manager->persist($adverts[$i]);
      }
      $manager->flush();
   }

   private function loadUtilMember(ObjectManager $manager)
   {
      //Création d'un utilisateur admin
      $utilManager = $this->container->get('fos_user.user_manager');
      $util = $utilManager->createUser();
      $util->setUsername('admin');
      $util->setEmail('email@domain.com');
      $util->setPlainPassword('admin');
      //$util->setPassword('3NCRYPT3D-V3R51ON');
      $util->setEnabled(true);
      $util->setRoles(array('ROLE_SUPER_ADMIN'));

      $utilManager->updateUser($util, true);

      //Création d'une image
      $image = new Image;
      $image->setUrl('uploads/img/personne.jpg');
      $manager->persist($image);

      //Création de membres page equipe
      $names = array(
         'Pierre'
      );

      $poste = 'Assistant techinque';

      $description = 'Iamque lituis cladium concrepantibus internarum non celate ut antea turbidum saeviebat ingenium a veri consideratione detortum et nullo inpositorum vel conpositorum.';

      foreach ($names as $name) {
         $member = new Member();
         $member->setFirstName($name);
         $member->setPost($poste);
         $member->setDescription($description);
         $member->setImage($image);

         $manager->persist($member);
      }
      $manager->flush();
   }
}
