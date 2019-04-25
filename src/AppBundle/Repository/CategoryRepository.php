<?php

namespace AppBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllOrdered()
    {
//        $dql = 'SELECT cat FROM AppBundle\Entity\Category cat ORDER BY cat.name DESC';
//        $query = $this->getEntityManager()->createQuery($dql);
//        var_dump($query->getSQL());die;
//        return $query->execute();
        $qb = $this->createQueryBuilder('cat')
        ->addOrderBy('cat.name', 'DESC')
        ;
        $query = $qb->getQuery();
//        var_dump($query->getDQL());die;
        return $query->execute();
    }
}
