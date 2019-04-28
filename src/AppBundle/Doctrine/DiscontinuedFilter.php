<?php

namespace AppBundle\Doctrine;

use Doctrine\ORM\Query\Filter\SQLFilter,
    Doctrine\ORM\Mapping\ClassMetadata;

class DiscontinuedFilter extends SQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetadata $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->getReflectionClass()->name != 'AppBundle\Entity\FortuneCookie') {
            return '';
        }
//        return sprintf('%s.discontinued = false', $targetTableAlias);

//        Control the value we're passing in the filter
        return sprintf('%s.discontinued = %s', $targetTableAlias, $this->getParameter('discontinued'));
//        var_dump($targetEntity);die;
    }
}