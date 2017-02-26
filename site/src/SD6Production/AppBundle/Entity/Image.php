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
   * @ORM\ManyToMany(targetEntity="SD6Production\AppBundle\Entity\Category", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
   public $categories;



   public function __construct()
   {
      $this->categories = new ArrayCollection();
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

   /**
   * Add category
   *
   * @param \SD6Production\AppBundle\Entity\Category $category
   *
   * @return Image
   */
   public function addCategory(\SD6Production\AppBundle\Entity\Category $category)
   {
      $this->categories[] = $category;

      return $this;
   }

   /**
   * Remove category
   *
   * @param \SD6Production\AppBundle\Entity\Category $category
   */
   public function removeCategory(\SD6Production\AppBundle\Entity\Category $category)
   {
      $this->categories->removeElement($category);
   }

   /**
   * Get categories
   *
   * @return \Doctrine\Common\Collections\Collection
   */
   public function getCategories()
   {
      return $this->categories;
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
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
   public function preUpload()
   {
      if ($this->file === null) {
         return;
      }

      $nom = $this->file->getClientOriginalName();

      $this->url = "uploads/img/".$nom;

      if ($this->alt === null) {
         $this->alt = $this->file->getClientOriginalName();
      }
   }

   /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
   public function upload()
   {
      if ($this->file === null) {
         return;
      }

      $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
   }

   /**
   * @ORM\PreRemove()
   */
   public function preRemoveUpload()
   {
      $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
   }

   /**
   * @ORM\PostRemove()
   */
   public function removeUpload()
   {
      if (file_exists($this->tempFilename)) {

         unlink($this->tempFilename);
      }
   }

   public function getUploadDir()
   {
      return 'uploads/img';
   }

   protected function getUploadRootDir()
   {
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
   }
}
