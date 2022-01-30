<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\EquipoMarca;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method EquipoMarca|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipoMarca|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipoMarca[]    findAll()
 * @method EquipoMarca[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipoMarcaRepository extends ServiceEntityRepository implements BaseRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipoMarca::class);
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
        $queryBuilder = $this->createQueryBuilder('equipoMarca')
            ->select('equipoMarca')
            ->orderBy('equipoMarca.nombreMarca', 'ASC')
        ;

        Paginator::queryTexts($queryBuilder, $params, ['equipoMarca.nombreMarca']);

        return $queryBuilder;
    }
}
