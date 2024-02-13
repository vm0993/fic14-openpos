<?php

namespace App\Core\Interface\Inventorys;

interface ItemAdjustmentInterface
{
    public function getAllAdjsutmentItems($request);

    public function getAdjsutmentNo($request);

    public function findAdjsutmentItemById($id);

    public function createAdjsutmentItems($request);

    public function updateAdjsutmentItems($request, $id);

    public function getDetailAdjsutmentById($id);
}
