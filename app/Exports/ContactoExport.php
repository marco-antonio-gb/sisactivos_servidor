<?php
namespace App\Exports;
use App\Models\Contacto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ContactoExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles {
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
                if($value==="created_at"){
                    $value='Creado';
                }if($value==="updated_at"){
                    $value="Actualizado";
                }if($value==="ci_ext"){
                    $value="Extension C.I.";
                }if($value==="ci"){
                    $value="C.I.";
                }
                $newArray[]=ucfirst($value);
            }
            return $newArray;
        }else{
            return [
                '#',
                'Apellidos',
                'Nombres',
                'C.I.',
                'Extension C.I.',
                'Correo',
                'Celular',
                'Cargo',
                'Direccion',
                'Tipo',
                'Creado',
                'Actualizado',
            ];
        }
	}
	public function collection() {
        if($this->columns){
            return Contacto::select($this->columns)->get();
        }else{
            return Contacto::all();
        }
	}
}
