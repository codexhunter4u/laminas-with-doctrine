<?php

declare(strict_types=1);

namespace User\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getPaginationQuery(): Query
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->select()
            ->orderBy('u.id', 'DESC');

        return $queryBuilder->getQuery();
    }
}
