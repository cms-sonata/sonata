<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function getPublishedQueryBuilder()
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.tags', 't')
            ->addSelect('t')
            ->andWhere('n.publishedAt IS NOT NULL')
            ->orderBy('n.publishedAt', 'DESC')
        ;
    }

    public function getWithSearchQueryBuilder($searchPhrase): QueryBuilder
    {
        $qb = $this->createQueryBuilder('n');

        if ($searchPhrase) {
            $qb
                ->andWhere('n.title LIKE :searchPhrase')
                ->setParameter('searchPhrase', '%'.$searchPhrase.'%')
            ;
        }

        return $qb->orderBy('n.createdAt', 'DESC');
    }

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
