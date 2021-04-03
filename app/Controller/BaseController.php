<?php

namespace App\Controller;

use Laminas\Diactoros\Response\HtmlResponse;

class BaseController
{
    public function render($url, $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . "/view");
        $twig = new \Twig\Environment($loader);
        $render = $twig->render($url, $data);
        return new HtmlResponse($render);
    }
}
