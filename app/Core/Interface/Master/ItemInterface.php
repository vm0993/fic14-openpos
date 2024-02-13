<?php

namespace App\Core\Interface\Master;

interface ItemInterface
{
    public function getAllItem();

    public function generateCodeByType($id);

    public function findItemById($id);

    public function getRawMaterialItems();

    public function createItem($request);

    public function updateItem($request, $id);

    public function suspendItemById($id);
}
