<?php

namespace App\Repository;

use App\Entity\SearchProgramForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchProgramForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchProgramForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchProgramForm[]    findAll()
 * @method SearchProgramForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchProgramFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchProgramForm::class);
    }

    // /**
    //  * @return SearchProgramForm[] Returns an array of SearchProgramForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchProgramForm
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
