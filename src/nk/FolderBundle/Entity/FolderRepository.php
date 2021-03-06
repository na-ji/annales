<?php

namespace nk\FolderBundle\Entity;

use Doctrine\ORM\EntityRepository;
use nk\DocumentBundle\Entity\Document;
use Doctrine\ORM\Query;

/**
 * FolderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FolderRepository extends EntityRepository
{
    public function getFolders(Document $document)
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f) total, f.id, f.name, f.slug, IDENTITY(f.author) author')
            ->join('nkDocumentBundle:Document', 'd')
            ->where('d MEMBER OF f.documents')
            ->andWhere('f IN (:folders)')
            ->setParameter('folders', $document->getFolders()->toArray())
            ->groupBy('f.id')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }
}
