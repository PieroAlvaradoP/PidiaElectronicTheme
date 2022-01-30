<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\TecnicoEncargado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method TecnicoEncargado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TecnicoEncargado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TecnicoEncargado[]    findAll()
 * @method TecnicoEncargado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TecnicoEncargadoRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TecnicoEncargado::class);
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
        $queryBuilder = $this->createQueryBuilder('tecnicoEncargado')
            ->select('tecnicoEncargado')
            ->orderBy('tecnicoEncargado.nombreTecnico', 'ASC')
        ;

        Paginator::queryTexts($queryBuilder, $params, ['tecnicoEncargado.nombreTecnico']);

        return $queryBuilder;
    }
}
