<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Advert
*
* @ORM\Table(name="advert")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\AdvertRepository")
* @ORM\InheritanceType("JOINED")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"autre" = "Advert", "casting" = "AdvertCasting"})
* @ORM\HasLifecycleCallbacks()
*/
class Advert
{
  const ADVERT_AUTRE = 'Autre';
  const ADVERT_CASTING = 'Casting';
  /**
  * @Gedmo\Slug(fields={"title"})
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
  * @ORM\Column(name="title", type="string", length=80)
  * @Assert\Length(
  *      min = 4,
  *      max = 80,
  *      minMessage = "Le titre de l'article doit faire {{ limit }} caractères mini.",
  *      maxMessage = "Le titre de l'article doit faire {{ limit }} caractères maxi."
  * )
  */
  private $title;

  /**
  * @var string
  *
  * @ORM\Column(name="taglines", type="string", length=128, nullable=true)
  */
  private $taglines;

  /**
  * @var string
  *
  * @ORM\Column(name="content", type="text")
  * @Assert\NotBlank(message="Le contenu ne peux pas être vide.")
  */
  private $content;

  /**
  * @var string
  *
  * @ORM\Column(name="author", type="string", length=30)
  * @Assert\Length(
  *      min = 2,
  *      max = 30,
  *      minMessage = "Nom de l'auteur doit faire {{ limit }} caractères mini.",
  *      maxMessage = "Nom de l'auteur doit faire {{ limit }} caractères maxi."
  * )
  */
  private $author;

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
  * @ORM\Column(name="published", type="boolean", nullable=true)
  */
  private $published;

  /**
  * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Category", cascade={"persist"})
  * @ORM\JoinColumn(nullable=true)
  */
  public $category;

  /**
  * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Image", cascade={"persist"})
  * @ORM\JoinColumn(nullable=true)
  */
  private $image;

  /**
  * @var bool
  *
  * @ORM\Column(name="pinned", type="boolean", nullable=true)
  */
  private $pinned;

  /**
  * @var string
  *
  * @ORM\Column(name="metaDescription", type="string", length=155, nullable=true)
  * @Assert\Length(
  *      min = 50,
  *      max = 155,
  *      minMessage = "La méta déscription doit faire {{ limit }} caractères mini",
  *      maxMessage = "La méta déscription doit faire {{ limit }} caractères maxi."
  * )
  */
  private $metaDescription;

  public function __construct()
  {
    // Par défaut, la date de l'advert est la date d'aujourd'hui
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
  * Set slug
  *
  * @param string $slug
  *
  * @return Advert
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
  * Set title
  *
  * @param string $title
  *
  * @return Advert
  */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
  * Get title
  *
  * @return string
  */
  public function getTitle()
  {
    return $this->title;
  }

  /**
  * Set taglines
  *
  * @param string $taglines
  *
  * @return Advert
  */
  public function setTaglines($taglines)
  {
    $this->taglines = $taglines;

    return $this;
  }

  /**
  * Get taglines
  *
  * @return string
  */
  public function getTaglines()
  {
    return $this->taglines;
  }

  /**
  * Set content
  *
  * @param string $content
  *
  * @return Advert
  */
  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  /**
  * Get content
  *
  * @return string
  */
  public function getContent()
  {
    return $this->content;
  }

  /**
  * Set author
  *
  * @param string $author
  *
  * @return Advert
  */
  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }

  /**
  * Get author
  *
  * @return string
  */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
  * Set date
  *
  * @param \DateTime $date
  *
  * @return Advert
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
  * Set published
  *
  * @param boolean $published
  *
  * @return Advert
  */
  public function setPublished($published)
  {
    $this->published = $published;

    return $this;
  }

  /**
  * Get published
  *
  * @return boolean
  */
  public function getPublished()
  {
    return $this->published;
  }

  /**
  * Set pinned
  *
  * @param boolean $pinned
  *
  * @return Advert
  */
  public function setPinned($pinned)
  {
    $this->pinned = $pinned;

    return $this;
  }

  /**
  * Get pinned
  *
  * @return boolean
  */
  public function getPinned()
  {
    return $this->pinned;
  }

  /**
  * Set category
  *
  * @param \SD6Production\AppBundle\Entity\Category $category
  *
  * @return Advert
  */
  public function setCategory(\SD6Production\AppBundle\Entity\Category $category = null)
  {
    $this->category = $category;

    return $this;
  }

  /**
  * Get category
  *
  * @return \SD6Production\AppBundle\Entity\Category
  */
  public function getCategory()
  {
    return $this->category;
  }

  /**
  * Set image
  *
  * @param \SD6Production\AppBundle\Entity\Image $image
  *
  * @return Advert
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
  * @ORM\PrePersist()
  * @ORM\PreUpdate()
  */
  public function preUpload()
  {
    if ($this->taglines == null) {
      $this->taglines = substr($this->content,0,124).'...';
    }
  }

  /**
   * @return string
   */
  public function getTypeAdvert(){
    return self::ADVERT_AUTRE;
  }

  /**
   * @return bool
   */
  public function isCasting(){
    return $this instanceof AdvertCasting;
  }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Advert
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }
}
