<?php

namespace App\Exports;

use App\NIR;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NIRExport implements FromCollection, WithHeadings
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
            'NIR',
            'Data NIR',
            'Furnizor',
            'DVI',
            'Data DVI',
            'Serie aviz',
            'Numar aviz',
            'Data aviz',
            'Specificatie',
            'WE',
            'Transport',
            'Numar inmatriculare',
            'Specie',
            'Tip',
            'Volum aviz',
            'Volum 2 zecimale',
            'Volum receptionat',
            'Umiditate',
            'Categorie',
        ];
    }
}
