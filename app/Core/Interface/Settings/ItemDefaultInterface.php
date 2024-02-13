<?php

namespace App\Core\Interface\Settings;

interface ItemDefaultInterface
{
    public function getItemDefault($company_id);

    public function createItemDefault($company_id, $request);

    public function updateItemDefault($company_id,$request, $id);
}
