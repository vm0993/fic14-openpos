<?php

namespace App\Core\Interface\Master;

interface IngradiantInterface
{
    public function getAllIngradiant();

    public function generateCode();

    public function findIngradiantById($id);

    public function getById($id);

    public function createIngradiant($request);

    public function updateIngradiant($request, $id);

    public function suspendIngradiantById($id);
}
