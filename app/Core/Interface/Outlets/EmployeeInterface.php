<?php

namespace App\Core\Interface\Outlets;

interface EmployeeInterface
{
    public function getAllEmployee($request);

    public function findEmployeeById($id);

    public function createEmployee($request);

    public function updateEmployee($request, $id);

    public function suspendEmployeeById($id);
}
