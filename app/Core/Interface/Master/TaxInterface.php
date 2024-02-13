<?php

namespace App\Core\Interface\Master;

interface TaxInterface
{
    public function getAllTaxes();

    public function findTaxById($id);

    public function createTax($request);

    public function updateTax($request, $id);

    public function suspendTax($id);
}
