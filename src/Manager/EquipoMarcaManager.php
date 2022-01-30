<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Manager;

use Pidia\Apps\Demo\Entity\EquipoMarca;
use Pidia\Apps\Demo\Repository\BaseRepository;

final class EquipoMarcaManager extends BaseManager
{
    public function repositorio(): \Doctrine\ORM\EntityRepository
    {
        return $this->manager()->getRepository(EquipoMarca::class);
    }

}
