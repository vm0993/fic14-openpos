<?php

namespace App\Core\Interface\Inventorys;

interface ItemIncomingInterface
{
    public function getAllIncomingItems($request);

    public function getIncomingNo($request);

    public function getDetailIncomingById($id);

    public function findIncomingItemById($id);

    public function createIncomingItems($request);

    public function updateIncomingItems($request, $id);

    public function getDetailIncomingItemById($id);
}
