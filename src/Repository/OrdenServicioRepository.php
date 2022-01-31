<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\OrdenServicio;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method OrdenServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdenServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdenServicio[]    findAll()
 * @method OrdenServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdenServicioRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdenServicio::class);
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
        $queryBuilder = $this->createQueryBuilder('ordenServicio')
            ->select('ordenServicio')
            ->orderBy('ordenServicio.numeroOrden', 'ASC')
        ;

        Paginator::queryTexts($queryBuilder, $params, ['ordenServicio.numeroOrden']);

        return $queryBuilder;
    }
}
