<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    private $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        dd($this->sales);
        return $this->sales->map(function ($sale) {
            return [
                'codigo' => $sale->code,
                'nombre_cliente' => $sale->client_name,
                'identificacion_cliente' => $sale->client_doc,
                'correo_cliente' => $sale->client_email,
                'cantidad_productos' => $sale->saleDetails->sum('quantity'),
                'monto_total' => $sale->total_amount,
                'fecha_hora' => $sale->date_time,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Código',
            'Nombre cliente',
            'Identificación cliente',
            'Correo cliente',
            'Cantidad productos',
            'Monto total',
            'Fecha y hora',
        ];
    }
}
