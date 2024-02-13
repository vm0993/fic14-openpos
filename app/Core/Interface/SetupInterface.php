<?php

namespace App\Core\Interface;

interface SetupInterface
{
    public function prepareProfileUsahaAndUser($request);

    public function storeProfileUsahaAndUser($boolean, $request);
}
