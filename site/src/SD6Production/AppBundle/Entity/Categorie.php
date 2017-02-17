<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Categorie
*
* @ORM\Table(name="categorie")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\CategorieRepository")
*/
class Categorie
{
  /**
  * @Gedmo\Slug(fields={"nom"})
  * @ORM\Column(name="slug", type="string", length=255, unique=true)
  */
  private $slug;

  /**
  * @var int
  *
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @var string
  *
  * @ORM\Column(name="nom", type="string", length=255)
  */
  private $nom;


  /**
  * Get id
  *
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set nom
  *
  * @param string $nom
  *
  * @return Categorie
  */
  public function setNom($nom)
  {
    $this->nom = $nom;

    return $this;
  }

  /**
  * Get nom
  *
  * @return string
  */
  public function getNom()
  {
    return $this->nom;
  }

  public function __toString() {
    return $this->nom;
  }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Categorie
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
