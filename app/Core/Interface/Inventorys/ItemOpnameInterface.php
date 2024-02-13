<?php

namespace App\Core\Interface\Inventorys;

interface ItemOpnameInterface
{
    public function getAllOpnameItems($request);

    public function getOpnameNo($request);

    public function findOpnameItemById($id);

    public function createOpnameItems($request);

    public function updateOpnameItems($request, $id);

    public function getDetailOpnameById($id);
}
