<?php

namespace App\Core\Interface\Settings;

interface PermissionGroupInterface
{
    public function getPermissionGroup();

    public function findPermissionGroupById($id);

    public function getPermissionDetailById($id);

    public function createPermissionGroup($request);

    public function updatePermissionGroup($request, $id);

    public function suspendPermissionGroup($id);
}
