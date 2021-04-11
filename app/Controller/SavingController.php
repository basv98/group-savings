<?php

namespace App\Controller;

use App\Model\{Meses, Saving};
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class SavingController extends BaseController
{
    public function saveSaving(ServerRequest $request)
    {
        $datos = $request->getparsedBody();
        try {
            v::key('anio', v::date("Y")->notEmpty())
                ->key('mount', v::intVal()->notEmpty())
                ->key('mes_id', v::intVal()->notEmpty())
                ->check($datos);
            $id_usuario = $_SESSION["id"];
            $saving = new Saving();
            $saving->user_id = $id_usuario;
            $saving->anio = $datos['anio'];
            $saving->mount = $datos['mount'];
            $saving->mes_id = $datos['mes_id'];
            $saving->save();
            return $this->json(["sucess" => true, "response" => "Guardado"]);;
        } catch (ValidationException $e) {
            return $this->json(["sucess" => false, "response" => $e->getMessage()]);
        }
    }

    public function saving(ServerRequest $request)
    {
        $datos = $request->getparsedBody();

        try {
            v::key('anio', v::date("Y")->notEmpty())
                ->key('mes_id', v::intVal())
                ->check($datos);
            $meses = $this->traerMeses($datos['mes_id']);
            $ahorros = $this->traerAhorros($meses, $datos['anio']);
            return $this->json(["sucess" => true, "saving" => $ahorros]);
        } catch (ValidationException $e) {
            return $this->json(["sucess" => false, "response" => $e->getMessage()]);
        }
    }

    public function montoMensual($user_id, $mes_id, $anio)
    {
        return Saving::selectRaw('sum(mount) AS ahorro')
            ->where([["user_id", $user_id], ["mes_id", $mes_id], ["anio", $anio]])->groupBy('mes_id')->get()[0];
    }

    public function traerMeses($mes_id)
    {
        if ($mes_id == 0) {
            $condicion = ["id", ">", 0];
        } else {
            $condicion = ["id", "=", $mes_id];
        }
        return Meses::where([$condicion])->get();
    }

    public function traerAhorros($meses, $anio)
    {
        $data = [['Mes', 'Jess', 'Bryan']];
        foreach ($meses as $mes) {
            $saving_bryan = $this->montoMensual(1, $mes->id, $anio);
            $saving_jess = $this->montoMensual(2, $mes->id, $anio);
            array_push($data, [$mes->mes, (int)$saving_jess->ahorro ?? 0, (int)$saving_bryan->ahorro ?? 0]);
        }
        return $data;
    }
}
