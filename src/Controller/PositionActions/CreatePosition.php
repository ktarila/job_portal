<?php
// api/src/Controller/PositionActions/CreatePosition.php

namespace App\Controller\PositionActions;

use App\Entity\Position;
use App\Handler\PositionHandler;

class CreatePosition
{
    private $positionHandler;

    public function __construct(PositionHandler $positionHandler)
    {
        $this->positionHandler = $positionHandler;
    }

    public function __invoke(Position $data): Position
    {
        $this->positionHandler->create($data);

        return $data;
    }
}
