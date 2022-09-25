<?php
namespace App\Exports;
use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsuariosExport implements FromCollection,WithDrawings,WithHeadings
{
    protected $codigo;
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }
    public function headings(): array
    {
        return [
            'idUsuario',
            'paterno',
            'materno',
            'nombres',
            'ci',
            'ci_ext',
            'direccion',
            'telefono',
            'celular',
            'cargo',
            'foto',
            'email',
            'activo'
        ];
    }
    public function collection()
    {
        return Usuario::all();
    }
    public function drawings()
    {
        $pab_name = $this->codigo;
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/'.$pab_name.'.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');
        return $drawing;
    }
}
