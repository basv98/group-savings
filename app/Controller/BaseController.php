<?php

namespace App\Controller;

use Laminas\Diactoros\Response\{HtmlResponse, RedirectResponse, JsonResponse};

class BaseController
{
    public function render($url, $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . "/view");
        $twig = new \Twig\Environment($loader);
        $render = $twig->render($url, $data);
        return new HtmlResponse($render);
    }

    public function redirect($url)
    {
        return new RedirectResponse($url);
    }

    public function json($data)
    {
        return new JsonResponse($data);
    }
}
