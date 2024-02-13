<?php

namespace App\Core\Interface\Master;

interface CategoryInterface
{
    public function getAllCategory();

    public function findCategoryById($id);

    public function createCategory($request);

    public function updateCategory($request, $id);

    public function suspendCategoryById($id);
}
