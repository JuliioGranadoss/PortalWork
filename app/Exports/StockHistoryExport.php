<?php

namespace App\Exports;

use App\Models\StockHistory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class StockHistoryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    private $place_id;
    private $personal_id;
    private $startDate;
    private $endDate;

    public function __construct($place_id, $personal_id, $startDate, $endDate)
    {
        $this->place_id = $place_id;
        $this->personal_id = $personal_id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;;
    }

    public function query()
{
    $query = StockHistory::query();

    if ($this->place_id) {
        $query->where('place_id', $this->place_id);
    }

    if ($this->personal_id) {
        $query->where('personal_id', $this->personal_id);
    }

    if ($this->startDate && $this->endDate) {
            $query->where('created_at', '>=', $this->startDate)
                  ->where('created_at', '<=', $this->endDate);
    }

    return $query->select('name', 'place_id',  'personal_id', 'quantity', 'type', 'created_at');
}


    public function headings(): array
    {
        return [
            'Producto',
            'Lugar',
            'Personal',
            'Cantidad',
            'Tipo',
            'Fecha',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->place ? $row->place->name : 'N/A',
            $row->personal ? $row->personal->name : 'N/A',
            $row->quantity,
            $row->type == 1 ? 'Entrada' : 'Salida',
            Carbon::createFromTimestamp($row->created_at)->format('d/m/Y H:i:s'),
        ];
    }
}
