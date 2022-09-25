<?php
namespace App\Exports;
use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class EmpresasExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    protected $columns;
	function __construct($columns) {
		$this->columns = $columns;
	}
	public function styles(Worksheet $sheet) {
		return [
			// Style the first row as bold text.
			1 => ['font' => ['bold' => true, 'size' => 12]],
		];
	}
    public function headings(): array
	{
        if($this->columns){
            $this->columns;
            $newArray=[];
            foreach ($this->columns as $key => $value) {
                if($value==="razon_social"){
                    $value='Razon social';
                }if($value==="created_at"){
                    $value='Creado';
                }if($value==="updated_at"){
                    $value="Actualizado";
                }if($value==="nit_cedula"){
                    $value="NIT/C.I.";
                }if($value==="sitio_web"){
                    $value="Sitio Web.";
                }
                $newArray[]=ucfirst($value);
            }
            return $newArray;
        }else{
            return [
                '#',
                'Razon social',
                'NIT/C.I.',
                'Ciudad',
                'Pais',
                'Direccion',
                'Telefono',
                'Celular',
                'Sitio web',
                'Redes sociales',
                'Correo',
                'Tipo empresa',
                'Oferta',
                'Demanda',
                'Logo',
                'Observaciones',
                'Contactos',
                'Rubro',
                'Creado',
                'Actualizado'
            ];
        }
	}
    public function collection()
    {
        if($this->columns){
            return Empresa::select($this->columns)->get();
        }else{
            return Empresa::all();
        }
    }
}
