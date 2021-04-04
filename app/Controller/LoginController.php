<?php

namespace App\Controller;

use App\Model\User;
use Laminas\Diactoros\ServerRequest;

class LoginController extends BaseController
{
    public function getIndex()
    {
        return $this->render("/loguin/loguin.twig");
    }

    public function auth(ServerRequest $request)
    {
        $datos = $request->getparsedBody();
        $correo = $datos['correo'];
        $user = User::where("email", $correo)->get()[0];
        if (count($user)) {
            $password = $datos['password'];
            if (password_verify($password, $user->password)) {
                $_SESSION["id"] = $user->id;
                return $this->redirect("/dashboard");
            }
        }
        return $this->render("/loguin/loguin.twig", ["response" => "Usuario o contraseña incorrecta"]);
    }
}
