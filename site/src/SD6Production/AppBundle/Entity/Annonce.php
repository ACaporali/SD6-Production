<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Annonce
*
* @ORM\Table(name="annonce")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\AnnonceRepository")
* @ORM\HasLifecycleCallbacks()
*/
class Annonce
{
   /**
   * @Gedmo\Slug(fields={"titre"})
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
   * @ORM\Column(name="titre", type="string", length=255)
   * @Assert\Length(
   *      min = 4,
   *      max = 80,
   *      minMessage = "Le titre de l'article doit faire {{ limit }} caractères mini.",
   *      maxMessage = "Le titre de l'article doit faire {{ limit }} caractères maxi."
   * )
   */
   private $titre;

   /**
   * @var string
   *
   * @ORM\Column(name="accroche", type="string", length=128, nullable=true)
   */
   private $accroche;

   /**
   * @var string
   *
   * @ORM\Column(name="contenu", type="text")
   * @Assert\NotBlank(message="Le contenu ne peux pas être vide.")
   */
   private $contenu;

   /**
   * @var string
   *
   * @ORM\Column(name="auteur", type="string", length=255)
   * @Assert\Length(
   *      min = 2,
   *      max = 30,
   *      minMessage = "Nom de l'auteur doit faire {{ limit }} caractères mini.",
   *      maxMessage = "Nom de l'auteur doit faire {{ limit }} caractères maxi."
   * )
   */
   private $auteur;

   /**
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime")
   * @Assert\DateTime(message="Date non valide.")
   */
   private $date;

   /**
   * @var bool
   *
   * @ORM\Column(name="publie", type="boolean", nullable=true)
   */
   private $publie;

   /**
   * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Categorie", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
   public $categorie;

   /**
   * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Image", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
   private $image;

   public function __construct()
   {
      // Par défaut, la date de l'annonce est la date d'aujourd'hui
      $this->date = new \Datetime();
   }

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
   * Set titre
   *
   * @param string $titre
   *
   * @return Annonce
   */
   public function setTitre($titre)
   {
      $this->titre = $titre;

      return $this;
   }

   /**
   * Get titre
   *
   * @return string
   */
   public function getTitre()
   {
      return $this->titre;
   }

   /**
   * Set accroche
   *
   * @param string $accroche
   *
   * @return Annonce
   */
   public function setAccroche($accroche)
   {
      $this->accroche = $accroche;

      return $this;
   }

   /**
   * Get accroche
   *
   * @return string
   */
   public function getAccroche()
   {
      return $this->accroche;
   }

   /**
   * Set contenu
   *
   * @param string $contenu
   *
   * @return Annonce
   */
   public function setContenu($contenu)
   {
      $this->contenu = $contenu;

      return $this;
   }

   /**
   * Get contenu
   *
   * @return string
   */
   public function getContenu()
   {
      return $this->contenu;
   }

   /**
   * Set auteur
   *
   * @param string $auteur
   *
   * @return Annonce
   */
   public function setAuteur($auteur)
   {
      $this->auteur = $auteur;

      return $this;
   }

   /**
   * Get auteur
   *
   * @return string
   */
   public function getAuteur()
   {
      return $this->auteur;
   }

   /**
   * Set date
   *
   * @param \DateTime $date
   *
   * @return Annonce
   */
   public function setDate($date)
   {
      $this->date = $date;

      return $this;
   }

   /**
   * Get date
   *
   * @return \DateTime
   */
   public function getDate()
   {
      return $this->date;
   }

   /**
   * Set publie
   *
   * @param boolean $publie
   *
   * @return Annonce
   */
   public function setPublie($publie)
   {
      $this->publie = $publie;

      return $this;
   }

   /**
   * Get publie
   *
   * @return bool
   */
   public function getPublie()
   {
      return $this->publie;
   }

   /**
   * Set image
   *
   * @param \SD6Production\AppBundle\Entity\Image $image
   *
   * @return Annonce
   */
   public function setImage(\SD6Production\AppBundle\Entity\Image $image = null)
   {
      $this->image = $image;

      return $this;
   }

   /**
   * Get image
   *
   * @return \SD6Production\AppBundle\Entity\Image
   */
   public function getImage()
   {
      return $this->image;
   }

   /**
   * Set slug
   *
   * @param string $slug
   *
   * @return Annonce
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

   /**
   * Set categorie
   *
   * @param \SD6Production\AppBundle\Entity\Categorie $categorie
   *
   * @return Annonce
   */
   public function setCategorie(\SD6Production\AppBundle\Entity\Categorie $categorie = null)
   {
      $this->categorie = $categorie;

      return $this;
   }

   /**
   * Get categorie
   *
   * @return \SD6Production\AppBundle\Entity\Categorie
   */
   public function getCategorie()
   {
      return $this->categorie;
   }


   /**
   * @ORM\prePersist()
   * @ORM\preUpdate()
   */
   public function preUpload()
   {
      if ($this->accroche == null) {
         $this->accroche = substr($this->contenu,0,124).'...';
      }
   }
}
