<?php

namespace App\Exports;

use App\Models\BillLate;
use App\Models\Customers;
use App\Models\Contracts;
use App\Models\Payment;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
// use App\Models\Project;
use App\Models\Juridical;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public $customerData;
    public $contractStatus;
    public $contractStatusCreated;
    public function __construct($customerData)
    {
        // dd($this->customerData);
        $this->customerData = $customerData;
        // dd($this->customerData);
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
    }

   public function collection()
   {

        $customers = [];
        foreach($this->customerData['data'] as $item){
            $customers[] = array(
                '0' => $item['customerName'],
                '1' => $item['cmnd'],
                '2' => $item['projectName'],
                '3' => $item['lot_number'],
                '4' => $item['status'],
                '5' => $item['payment_progress'],
                '6' => Billlate::where('payment_id',$item['paymentId'])->first() ? "Trễ hạn" : "Đúng hạn",
            );
        }
        
        return (collect($customers));
   }

    public function headings(): array
    {
        return [
            'Họ và Tên',
            'Cmnd' ,
            'Dự án' ,
            'Mã lô',            
            'Tình trạng',
            'Tiến độ thanh toán' ,
            'Trạng thái'
        ];
    }

}
