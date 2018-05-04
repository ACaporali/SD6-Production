<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* Image
*
* @ORM\Table(name="image")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\ImageRepository")
* @ORM\HasLifecycleCallbacks
*/
class Image
{
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
  * @ORM\Column(name="url", type="text", nullable=true)
  */
  private $url;

  /**
  * @var string
  *
  * @ORM\Column(name="alt", type="string", length=255, nullable=true)
  */
  private $alt;

  /**
  * @Assert\File(
  *     maxSize = "8192k",
  *     mimeTypes = {"image/png", "image/jpeg", "image/jpg", "image/gif"},
  *     mimeTypesMessage = "Taille ou format de l'image incorrect. Max taille : 1024k, format : jepg, jpg, png, gif."
  * )
  */
  private $file;

  private $tempFilename;

  /**
  * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Category", cascade={"persist"})
  * @ORM\JoinColumn(nullable=true)
  */
  public $category;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="date", type="datetime")
  * @Assert\DateTime(message="Date non valide.")
  */
  private $date;



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
  * Set url
  *
  * @param string $url
  *
  * @return Image
  */
  public function setUrl($url)
  {
    $this->url = $url;

    return $this;
  }

  /**
  * Get url
  *
  * @return string
  */
  public function getUrl()
  {
    return $this->url;
  }

  /**
  * Set alt
  *
  * @param string $alt
  *
  * @return Image
  */
  public function setAlt($alt)
  {
    $this->alt = $alt;

    return $this;
  }

  /**
  * Get alt
  *
  * @return string
  */
  public function getAlt()
  {
    return $this->alt;
  }

  public function getFile()
  {
    return $this->file;
  }

  public function setFile(UploadedFile $file = null)
  {
    $this->file = $file;
  }



    /**
     * Set category
     *
     * @param \SD6Production\AppBundle\Entity\Category $category
     *
     * @return Image
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Image
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
}
