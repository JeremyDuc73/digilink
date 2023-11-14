<?php

namespace App\Repository;

use App\Entity\RoleInSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoleInSchool>
 *
 * @method RoleInSchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleInSchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleInSchool[]    findAll()
 * @method RoleInSchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleInSchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleInSchool::class);
    }

//    /**
//     * @return RoleInSchool[] Returns an array of RoleInSchool objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RoleInSchool
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
