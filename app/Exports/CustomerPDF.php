<?php

namespace App\Exports;

use App\Models\Customers;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerPDF
{
    // use Exportable;
    public $dataRender;
    public function __construct($dataRender)
    {
        // dd($data);
        $this->dataRender = $dataRender;
        // dd($this->dataRender);
        // return $this->exportPDF();
        $this->exportPDF();
    }

    public function exportPDF()
    {
        return PDF::loadView('exportPDF', ['customers' => $this->dataRender]);
    }

}
