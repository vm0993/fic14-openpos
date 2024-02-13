<?php

namespace App\Core\Interface\Pos;

interface SaleInterface
{
    public function getAllSales($request);

    public function getDetailSalesById($id);

    public function storeSales($request);

    public function updateSales($request, $id);

}
