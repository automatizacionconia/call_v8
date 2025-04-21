<?php

namespace App\Http\Controllers\Api\Call\Exports;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Call\Models\Cartera;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class CarteraExport extends DefaultValueBinder implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithCustomValueBinder
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $data = Cartera::search($this->request)
            ->where('GRUP_CODIGO', $this->request->grup_codigo)
            ->orderBy('CART_CODIGO', 'desc')
            ->with('cliente')
            ->with('agente')
            ->get();
        
        return collect($data);
    }

    public function headings(): array
    {
        return [
            // Cabecera principal
            ['ITEM', 'CLIENTES CARGADOS PARA LA LLAMADA'],

            // Subcabeceras
            [
                'ITEM',
                'AGENTE NOMBRE',
                'CLIENTE NOMBRES',
                'CLIENTE MONTO',
                'CLIENTE TELEFONO',
                'FECHA LLAMADA',
                'GRUPO NOMBRE',
                'ESTADO'
            ],
        ];
    }

    public function title(): string
    {
        return 'Llamadas';
    }

    public function map($row): array
    {
        static $counter = 1;
        
        return [
            $counter++,
            $row->agente->AGEN_NOMBRE,
            $row->cliente->CLIE_NOMBRES,
            $row->cliente->CLIE_DEUDA,
            $row->cliente->CLIE_CELULAR,
            $row->CART_FECHENVIO ? Carbon::parse($row->CART_FECHENVIO)->format('Y-m-d H:i:s') : null,
            $row->grupo->GRUP_NOMBRE ?? '[Sin grupo]',
            $row->estado->C_ESTA_NOMBRE ?? '[Sin estado]',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para la cabecera principal
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '3F51B5'],
            ],
        ];
        
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getStyle('C:C')->getAlignment()->setWrapText(true);

        // Aplicar estilo a la cabecera principal (fila 1)
        $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

        // Combinar celdas para la cabecera principal
        $sheet->mergeCells('A1:A2'); // ITEM
        $sheet->mergeCells('B1:H1'); // CLIENTES CARGADOS PARA LA LLAMADA

        // Estilo para las subcabeceras (fila 2)
        $sheet->getStyle('A2:H2')->applyFromArray($styleArray);
        
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A' || $cell->getColumn() == 'B' || $cell->getColumn() == 'I') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}