<?php

namespace nk\ExamBundle\Entity;

use Doctrine\ORM\EntityRepository;
use nk\UserBundle\Entity\User;

/**
 * ExamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExamRepository extends EntityRepository
{
    public function truncate()
    {
        $connection = $this->_em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('nk_exam', false));
    }

    public function findNext(User $user = null)
    {
        $qb = $this->createQueryBuilder('e')
//            ->where('e.startAt > CURRENT_TIMESTAMP()')
            ->orderBy('e.startAt');

        if($user !== null){
            $qb->andWhere('e.resource = :resource')
                ->setParameter('resource', $user->getResource());

            if(count($user->getIgnoredExams()))
                $qb->andWhere('e.unit NOT IN (:ignoredUnits)')
                ->setParameter('ignoredUnits', $user->getIgnoredUnits());
        }

        return $qb->getQuery()->getResult();
    }
}
