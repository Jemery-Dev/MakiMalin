<?php

namespace App\Repository;

use App\Entity\ListeDeCourses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeDeCourses>
 *
 * @method ListeDeCourses|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeDeCourses|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeDeCourses[]    findAll()
 * @method ListeDeCourses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeDeCoursesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeDeCourses::class);
    }

//    /**
//     * @return ListeDeCourses[] Returns an array of ListeDeCourses objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ListeDeCourses
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
