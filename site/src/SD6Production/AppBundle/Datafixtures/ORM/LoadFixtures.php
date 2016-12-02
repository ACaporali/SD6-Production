<?php

namespace SD6Production\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SD6Production\AppBundle\Entity\Categorie;
use SD6Production\AppBundle\Entity\Annonce;
use SD6Production\AppBundle\Entity\Membre;
use SD6Production\AppBundle\Entity\Image;

class LoadFixtures implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $this->loadCategories($manager);
  }

  private function loadCategories(ObjectManager $manager)
  {
    $names = array(
      'Actualite',
      'Evenement',
      'Production',
      'Recrutement'
    );

    foreach ($names as $name) {
      $categorie = new Categorie();
      $categorie->setNom($name);

      $manager->persist($categorie);
    }

    $manager->flush();
  }
}