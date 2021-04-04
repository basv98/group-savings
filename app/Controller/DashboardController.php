<?php

namespace App\Controller;

class DashboardController extends BaseController
{
    public function getIndex()
    {
        return $this->render("/dashboard/index.twig", ["data" => ["hola" => "hola mundo"]]);
    }
}
