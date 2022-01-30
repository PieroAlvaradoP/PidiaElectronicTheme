<?php

namespace Pidia\Apps\Demo\Repository;

use Pidia\Apps\Demo\Entity\TecnicoEncargado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TecnicoEncargado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TecnicoEncargado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TecnicoEncargado[]    findAll()
 * @method TecnicoEncargado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TecnicoEncargadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TecnicoEncargado::class);
    }

    // /**
    //  * @return TecnicoEncargado[] Returns an array of TecnicoEncargado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TecnicoEncargado
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
