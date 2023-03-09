<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Usuario;
use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Asignacion;
use App\Models\Responsable;
use App\Models\OrgFinanciero;
use App\Models\Transferencia;

class InfoInicioController extends Controller
{
    public function InfoInicio()
    {
        $info_result = [
            'articulos' => $this->InfoArticulos(),
            'bajas' => $this->InfoBajas(),
            'responsables' => $this->InfoResponsables(),
            'asignaciones' => $this->InfoAsignaciones(),
            'usuarios' => $this->InfoUsuarios()
        ];
        return response()->json([
            'success' => true,
            'data' => $info_result
        ], 200);
    }
    public function InfoArticulos()
    {
        $result = Articulo::where('baja', '=', false)->where('deleted_at', '=', null)->with('categoria')->with('orgfinanciero')->count();
        return $result;
    }
    public function InfoBajas()
    {
        $result = Baja::count();
        return $result;
    }
    public function InfoResponsables()
    {
        $result = Responsable::count();
        return $result;
    }
    public function InfoAsignaciones()
    {
        $result = Asignacion::count();
        return $result;
    }
    public function InfoUsuarios()
    {
        $result = Usuario::count();
        return $result;
    }
}
