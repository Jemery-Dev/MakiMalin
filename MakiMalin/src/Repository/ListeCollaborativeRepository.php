<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\ListeCollaborative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeCollaborative>
 *
 * @method ListeCollaborative|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeCollaborative|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeCollaborative[]    findAll()
 * @method ListeCollaborative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeCollaborativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeCollaborative::class);
    }

    public function findByUtilisateur(Utilisateur $utilisateur): array
    {
        return $this->createQueryBuilder('lc')
            ->andWhere(':utilisateur MEMBER OF lc.utilisateurs')
            ->setParameter('utilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return ListeCollaborative[] Returns an array of ListeCollaborative objects
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

//    public function findOneBySomeField($value): ?ListeCollaborative
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}
