<?php

namespace App\Exports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PDF;

class CustomerPDF
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $customerData;
    public function __construct($customerData)
    {
        $this->customerData = $customerData;
        $pdf = PDF::loadView('print',  [
            'customerData' =>  $customerData ,
        ]);
    }

}
