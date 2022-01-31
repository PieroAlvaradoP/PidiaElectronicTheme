<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\DetalleOrden;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method DetalleOrden|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleOrden|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleOrden[]    findAll()
 * @method DetalleOrden[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleOrdenRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleOrden::class);
    }

    public function findLatest(array $params): Paginator
    {
        $queryBuilder = $this->filterQuery($params);

        return Paginator::create($queryBuilder, $params);
    }

    public function filter(array $params, bool $inArray = true): array
    {
        $queryBuilder = $this->filterQuery($params);

        if (true === $inArray) {
            return $queryBuilder->getQuery()->getArrayResult();
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function filterQuery(array $params): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('detalleOrden')
            ->select('detalleOrden')
            ->orderBy('detalleOrden.ordenServicio', 'ASC')
        ;

        Paginator::queryTexts($queryBuilder, $params, ['detalleOrden.ordenServicio']);

        return $queryBuilder;
    }

}
