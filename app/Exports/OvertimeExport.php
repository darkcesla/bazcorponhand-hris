<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OvertimeExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $columns;

    public function __construct($data, $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    public function collection()
    {
        try {
            if ($this->data === null) {
                throw new \Exception("Data is null");
            }

            return $this->data;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
