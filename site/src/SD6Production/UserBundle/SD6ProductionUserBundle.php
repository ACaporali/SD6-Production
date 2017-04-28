<?php

namespace SD6Production\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SD6ProductionUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
