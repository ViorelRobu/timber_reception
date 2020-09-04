<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClaimsExport implements FromCollection, WithHeadings
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Reclamatie',
            'Frunizor',
            'Data reclamatie',
            'NIR-uri reclamate',
            'Defecte',
            'Cantitate reclamata',
            'Valoare reclamata',
            'valuta',
            'Status',
            'Observatii',
            'Rezolvare',
            'Facturi'
        ];
    }
}
