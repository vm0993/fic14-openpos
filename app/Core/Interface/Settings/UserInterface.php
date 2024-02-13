<?php

namespace App\Core\Interface\Settings;

interface UserInterface
{
    public function getUsers();

    public function findUserById($id);

    public function createUserByPermission($id, $request);

    public function createUser($request);

    public function updateUser($request, $id);

    public function suspendUser($id);
}
