<?php

namespace App\Core\Interface\Outlets;

interface PromoInterface
{
    public function getAllPromo($request);

    public function getDetailPromoById($id);

    public function findPromoById($id);

    public function createPromo($request);

    public function updatePromo($request, $id);

    public function suspendPromoById($id);
}
