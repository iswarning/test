<?php

namespace App\Exports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $customerData;
    public function __construct($customerData)
    {
        $this->customerData = $customerData;
    }

    public function collection()
    {
        $customers = $this->customerData;
        $customer[] = array(
            0 => $customers['id'] ,
            1 => $customers['name'] ,
            2 => $customers['cmnd'] ,
            3 => $customers['phone'] ,
            4 => $customers['address'] ,
            5 => $customers['household'] ,
            6 => $customers['birthday'] ,
        );
        return collect($customer);

    }

    public function headings(): array
    {
        return [
            'id',
            'Họ và Tên',
            'Cmnd' ,
            'Số điện thoại',
            'Địa Chỉ',
            'Hộ Khẩu',
            'Ngày Sinh',
        ];
    }
}
