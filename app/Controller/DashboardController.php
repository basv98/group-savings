<?php

namespace App\Controller;

use Laminas\Diactoros\Response\JsonResponse;

class DashboardController extends BaseController
{
    public function __construct()
    {
        return $this->redirect("/login");
    }

    public function getIndex()
    {

        return $this->render("/dashboard/index.twig", ["data" => ["hola" => "hola mundo"]]);
    }
}
