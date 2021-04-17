<?php

namespace App\Controller;

use App\Model\Goal;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class GoalController extends BaseController
{
    public function goal(ServerRequest $request)
    {
        $datos = $request->getparsedBody();
        $goal = Goal::where("anio", $datos['anio'])->first();
        $goal = $goal != null ? $goal : 0;
        return $this->json($goal);
    }

    public function guardarController(ServerRequest $request)
    {
        $datos = $request->getparsedBody();
        try {
            v::key('anio', v::date("Y")->notEmpty())
                ->key('mount', v::intVal()->notEmpty())
                ->check($datos);
            $goal = Goal::where("anio", $datos['anio'])->first();
            if ($goal) {
                $goal->mount = $datos['mount'];
                $goal->save();
                return $this->json(["sucess" => true, "response" => "Actualizado"]);;
            } else {
                return $this->json(["sucess" => false, "response" => "No se encontró el año buscado"]);;
            }
        } catch (ValidationException $e) {
            return $this->json(["sucess" => false, "response" => $e->getMessage()]);
        }
    }
}
