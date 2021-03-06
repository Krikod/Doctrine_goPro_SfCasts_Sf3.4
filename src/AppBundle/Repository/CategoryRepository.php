<?php

namespace AppBundle\Repository;
use Doctrine\ORM\QueryBuilder;

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
        ->addOrderBy('cat.name', 'DESC');
//        On remplace le Join et AddSelect par la Private function
        $this->addFortuneCookieJoinAndSelect($qb);

        $query = $qb->getQuery();
//        var_dump($query->getDQL());die;
        return $query->execute();
    }

    public function search($term)
    {
        $qb = $this->createQueryBuilder('cat')
//            => QUERY TERMES EXACTS:
//            ->andWhere('cat.name = :searchTerm')
//                  (avoids SQL injection attacks:)
//            ->setParameter('searchTerm', $term)

//            => QUERY TERMES NON EXACTS
//            'LIKE / =' : result matche partie/tout de la query:
//            ->andWhere('cat.name LIKE :searchTerm')
//            ->setParameter('searchTerm', '%'.$term.'%')

//            => QUERY sur name OR iconKey property
            ->andWhere('cat.name LIKE :searchTerm 
                        OR cat.iconKey LIKE :searchTerm
                        OR fc.fortune LIKE :searchTerm');
        $this->addFortuneCookieJoinAndSelect($qb);

        return $qb
            ->setParameter('searchTerm', '%'.$term.'%')
//            (on peut chercher "fa-bug")
            ->getQuery()->execute();
    }

    public function findWithFortunesJoin($id)
    {
        $qb = $this->createQueryBuilder('cat')
            ->andWhere('cat.id = :id');
        $this->AddFortuneCookieJoinAndSelect($qb);
        return $qb
            ->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * Joins over to cat.fortuneCookies AND selects its fields
     *
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    private function AddFortuneCookieJoinAndSelect(QueryBuilder $qb)
    {
        return$qb->leftJoin('cat.fortuneCookies', 'fc')
            ->addSelect('fc');
    }
}
