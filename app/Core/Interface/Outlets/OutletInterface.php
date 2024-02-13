<?php

namespace App\Core\Interface\Outlets;

interface OutletInterface
{
    public function getAllOutlet($request);

    public function findOutletById($id);

    public function createOutlet($request);

    public function updateOutlet($request, $id);

    public function suspendOutletById($id);
}
