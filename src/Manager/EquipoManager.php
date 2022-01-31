<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Manager;

use Pidia\Apps\Demo\Entity\Equipo;
use Pidia\Apps\Demo\Repository\BaseRepository;

final class EquipoManager extends BaseManager
{
    public function repositorio(): BaseRepository
    {
        return $this->manager()->getRepository(Equipo::class);
    }
}
