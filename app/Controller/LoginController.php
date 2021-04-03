<?php

namespace App\Controller;

use App\Model\User;

class LoginController extends BaseController
{
    public function getIndex()
    {
        return $this->render("/loguin/loguin.twig");
    }
}
