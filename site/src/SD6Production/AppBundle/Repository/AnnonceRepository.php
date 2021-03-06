<?php

namespace SD6Production\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* AnnonceRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class AnnonceRepository extends EntityRepository
{
	public function getAnnonceCategories($categorieNoms){
		$qb = $this->createQueryBuilder('a');

		$qb->join('a.categorie', 'cat')
		->addSelect('cat');

		$qb->where('cat.nom = :catNom')
		->setParameter('catNom', $categorieNoms);

		$qb->andWhere('a.publie = :publie')
		->setParameter('publie', true)
		->orderBy('a.date', 'DESC');

		return $qb
		->getQuery()
		->getResult();
	}

	public function getAdvertNb($nbAnnonce){
		$qb = $this->createQueryBuilder('a');

		$qb->where('a.publie = :publie')
		->setParameter('publie', true)
		->orderBy('a.date', 'DESC')
		->setMaxResults($nbAnnonce);

		return $qb
		->getQuery()
		->getResult();
	}

	public function getAdvertNbWithCategory($nbAnnonce, $categorieNoms){
		$qb = $this->createQueryBuilder('a');

		$qb->join('a.categorie', 'cat')
		->addSelect('cat');

		$qb->where('cat.nom = :catNom')
		->setParameter('catNom', $categorieNoms);

		$qb->andWhere('a.publie = :publie')
		->setParameter('publie', true)
		->orderBy('a.date', 'DESC')
		->setMaxResults($nbAnnonce);

		return $qb
		->getQuery()
		->getResult();
	}
}
