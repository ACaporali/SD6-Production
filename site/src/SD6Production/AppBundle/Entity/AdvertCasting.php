<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* AdvertCasting
*
* @ORM\Table(name="advert_casting")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\AdvertCastingRepository")
*/
class AdvertCasting extends Advert
{
  /**
  * @var \DateTime
  *
  * @ORM\Column(name="closure", type="datetimetz")
  */
  private $closure;

  public function __construct() {
    parent::__construct();
  }

  /**
  * Set closure
  *
  * @param \DateTime $closure
  *
  * @return AdvertCasting
  */
  public function setClosure($closure)
  {
    $this->closure = $closure;

    return $this;
  }

  /**
  * Get closure
  *
  * @return \DateTime
  */
  public function getClosure()
  {
    return $this->closure;
  }

  /**
  * @return string
  */
  public function getTypeAdvert(){
    return self::ADVERT_CASTING;
  }
}
