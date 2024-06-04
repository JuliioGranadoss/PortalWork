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
    private $date;

    public function __construct($place_id, $personal_id, $date)
    {
        $this->place_id = $place_id;
        $this->personal_id = $personal_id;
        $this->date = $date;
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

        if ($this->date) {
            $query->whereDate('updated_at', $this->date);
        }

        return $query->select('name', 'place_id',  'personal_id', 'quantity', 'type', 'updated_at');
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
            Carbon::createFromTimestamp($row->updated_at)->format('d/m/Y H:i:s'),
        ];
    }
}
