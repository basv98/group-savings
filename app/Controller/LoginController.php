<?php

namespace App\Controller;

use App\Model\User;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class LoginController extends BaseController
{
    public function getIndex()
    {
        return $this->render("/loguin/loguin.twig");
    }

    public function auth(ServerRequest $request)
    {
        $datos = $request->getparsedBody();
        $valida = $this->validaLogin($datos);
        if ($valida === true) {
            $correo = $datos['correo'];
            $user = User::where("email", $correo)->first();
            if ($user) {
                $password = $datos['password'];
                if (password_verify($password, $user->password)) {
                    $_SESSION["id"] = $user->id;
                    return $this->redirect("/dashboard");
                }
            }
            return $this->render("/loguin/loguin.twig", ["response" => "Usuario o contraseña incorrecta"]);
        } else {
            return $valida;
        }
    }

    public function validaLogin($datos)
    {
        try {
            return v::key('correo', v::email()->notEmpty())
                ->key('password', v::stringType()->notEmpty())
                ->check($datos);
        } catch (ValidationException $e) {
            return $this->render("/loguin/loguin.twig", ["response" => $e->getMessage()]);
        }
    }
}
