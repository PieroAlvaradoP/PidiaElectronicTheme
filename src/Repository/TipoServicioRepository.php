<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\TipoServicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method TipoServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoServicio[]    findAll()
 * @method TipoServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoServicioRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoServicio::class);
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
        $queryBuilder = $this->createQueryBuilder('tipoServicio')
            ->select('tipoServicio')
            ->orderBy('tipoServicio.id', 'ASC')
        ;

        Paginator::queryTexts($queryBuilder, $params, ['tipoServicio.id']);

        return $queryBuilder;
    }

}
