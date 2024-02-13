<?php

namespace App\Core\Interface\Master;

interface CustomerInterface
{
    public function getAllCustomer();

    public function findCustomerById($id);

    public function createCustomer($request);

    public function updateCustomer($request, $id);

    public function suspendCustomerById($id);
}
