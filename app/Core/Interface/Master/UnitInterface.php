<?php

namespace App\Core\Interface\Master;

interface UnitInterface
{
    public function getAllUnit();

    public function findUnitById($id);

    public function createUnit($request);

    public function updateUnit($request, $id);

    public function suspendUnitById($id);
}
