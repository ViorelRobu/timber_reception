<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PackagingExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder, WithStrictNullComparison
{
    use Exportable;

    private $headings;
    private $data;

    public function __construct($headings, $data)
    {
        $this->headings = $headings;
        $this->data = $data;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (\is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
