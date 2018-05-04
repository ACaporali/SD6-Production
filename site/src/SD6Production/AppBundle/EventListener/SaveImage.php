<?php
namespace SD6Production\AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SD6Production\AppBundle\Entity\Image;

class SaveImage {
  private $tempFilename;

  public function prePersist(LifecycleEventArgs $args){
    $this->logger = 'lala';
    $entity = $args->getEntity();

    $entityManager = $args->getEntityManager();
    // ... do something with the Image

    // only act on some "Image" entity
    if ($entity instanceof Image) {
      $this->logger = 'ICI1';
      $this->preUpload($entity);
      $this->upload();
      //return;
    }
  }

  public function preUpdate(LifecycleEventArgs $args){
    $this->logger = 'lala';
    $entity = $args->getEntity();

    $entityManager = $args->getEntityManager();
    // ... do something with the Image

    // only act on some "Image" entity
    if ($entity instanceof Image) {
      $this->logger = 'ICI2';
      $this->preUpload();
      $this->upload();
      //return;
    }
  }

  public function preRemove(LifecycleEventArgs $args){
    $entity = $args->getEntity();

    $entityManager = $args->getEntityManager();
    // ... do something with the Image

    // only act on some "Image" entity
    if ($entity instanceof Image) {
      $this->logger = 'ICI3';
      $this->preRemoveUpload();
      //return;
    }
  }

  public function postRemove(LifecycleEventArgs $args){
    $entity = $args->getEntity();

    $entityManager = $args->getEntityManager();
    // ... do something with the Image

    // only act on some "Image" entity
    if ($entity instanceof Image) {
      $this->logger = 'ICI4';
      $this->removeUpload();
      //return;
    }
  }

  /*public function preUpload($entity){
    dump('ici');
    die();
    if ($entity->getFile() === null) {
      return;
    }

    $nom = $entity->getFile()->getClientOriginalName();

    $entity->getUrl() = "uploads/img/".$nom;

    if ($entity->getAlt() === null) {
      $entity->getAlt() = $entity->getFile()->getClientOriginalName();
    }
  }*/

  public function upload(){
    if ($entity->getFile() === null) {
      return;
    }

    $entity->getFile()->move($this->getUploadRootDir(), $entity->getFile()->getClientOriginalName());
  }

  public function preRemoveUpload(){
    $this->tempFilename = $this->getUploadRootDir().'/'.$entity->getId.'.'.$entity->getUrl;
  }

  public function removeUpload(){
    if (file_exists($this->tempFilename)) {

      unlink($this->tempFilename);
    }
  }

  public function getUploadDir(){
    return 'uploads/img';
  }

  protected function getUploadRootDir(){
    if($this->container->getParameter('prodMode')){
      return __DIR__.'/../../../../www/'.$this->getUploadDir();
    }else{
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
  }
}
?>
