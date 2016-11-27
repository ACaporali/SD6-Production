<?php

namespace SD6Production\UtilisateurBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SD6ProductionUtilisateurBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
