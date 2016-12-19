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
    $this->loadCatImageAnnonce($manager);
  }

  private function loadCatImageAnnonce(ObjectManager $manager)
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

    $image = new Image;
    $image->setUrl('uploads/img/image.jpg');
    $manager->persist($image);

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
        $manager->persist($annonces[$i]);
    }


    $manager->flush();
  }
}
