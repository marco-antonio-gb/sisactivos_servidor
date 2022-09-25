<?php
namespace App\Imports;
use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\ToModel;
class EmpresaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Empresa([
            'razon_social' =>$row[0],
            'nit_cedula' =>$row[1],
            'ciudad' =>$row[2],
            'rubro_id'=>2
        ]);
    }
}
