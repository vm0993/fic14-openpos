<?php

namespace App\Core\Interface\Settings;

interface CompanyInterface
{
    public function getCompany();

    public function createCompany($request);

    public function updateCompany($request, $id);
}
