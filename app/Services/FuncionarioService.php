<?php
namespace App\Services;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class FuncionarioService
{
    public function createFuncionario(Request $request): Funcionario
    {
        $funcionario = Funcionario::create([
            'apellidos' => $request->apellidos,
            'nombres'   => $request->nombres,
            'ci'        => $request->ci,
            'ci_ext'    => $request->ci_ext,
            'cargo'     => $request->cargo,
            'documento' => $request->documento,
        ]);
        return $funcionario;
    }
    
}