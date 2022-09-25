<?php
namespace App\Exports;
use App\Models\Codigo;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class CodigosExport implements FromCollection, WithHeadings, WithEvents {
	protected $evento_id;
	protected $codigos;
    protected $folderName;

	public function __construct($evento_id, $folderName) {
		$this->evento_id = $evento_id;
		$this->folderName = $folderName;
	}
	public function headings(): array
	{
		return [
			'Tipo',
			'Numero',
			'Codigo',
			'Imagen',
		];
	}
	public function registerEvents(): array
	{
		return [
			AfterSheet::class => function (AfterSheet $event) {
				$evento_id = $this->evento_id;
				$codigos   = Codigo::where('evento_id', '=', $evento_id)->get();
				$event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
				$event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
				$event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
				$event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
				$cellRange = 'A1:W1'; // All headers
				// $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
				$styleArray = [
					'font'      => [
						'bold' => true,
						'size' => 12,
					],
					'alignment' => [
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],
				];
				$event->sheet->getStyle('A1:W1')->applyFromArray($styleArray);
				for ($i = 2; $i <= ($codigos->count() + 1); $i++) {
					$event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(80);
					$event->sheet->getStyle($i)->getAlignment()->applyFromArray(
						array('vertical' => 'center'));
				}
				$drawings = [];
				$pab_name = $this->evento_id;
				$fots     = Codigo::where('evento_id', '=', $pab_name)->get();
                $folderName = $this->folderName;
				foreach ($fots as $key => $value) {
					# code...
					$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
					$drawing->setName($value['codigo_secuencia']);
					$drawing->setDescription($key);
					$drawing->setPath(public_path('/credenciales/'.$folderName.'/imagenes/' . $value['codigo_barra'] . '.png'));
					$drawing->setHeight(100);
					$drawing->setWidth(100);
					$drawing->setCoordinates('D' . ($key + 2));
					$drawing->setWorksheet($event->sheet->getDelegate());
				}
			},
		];
	}
	public function collection() {
		$evento_id = $this->evento_id;
		$result    = Codigo::join('tipo_credenciales', 'tipo_credenciales.idTipoCredencial', '=', 'codigos.tipocredencial_id')->select('nombre', 'codigo_barra', 'codigo_secuencia')->where('tipo_credenciales.evento_id', '=', $evento_id)->get();
		return $result;
	}
 
}
