<?php

namespace App\Exports;

use App\Models\Customers;
use App\Models\Contracts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
use App\Models\Project;

class CustomerExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings
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
        $this->customerData = $customerData;
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
    }

//    public function collection()
//    {
//        $customers = $this->customerData;
//        $contract = $this->contractData;
//        $data[] = array(
//            0 => $customers['id'] ,
//            1 => $customers['name'] ,
//            2 => $customers['cmnd'] ,
//            3 => $customers['phone'] ,
//            4 => $customers['address'] ,
//            5 => $customers['household'] ,
//            6 => $customers['birthday'] ,
//        );
//        foreach($contract as $value)
//        {
//            $data[] = array(
//              9 => $value->contract_no ,
//            );
//        }
//        return collect($data);
//
//    }

    public function query()
    {
        return Contracts::query()->join('customers','customers.id','contracts.customer_id')
            ->where('contracts.customer_id',$this->customerData['id']);
    }

    public function map($contractData): array
    {
        if($contractData->signed == 0){
            $contractSigned = "Chưa ký";
        }else{
            $contractSigned = "Đã ký";
        }
        $project = Project::find($contractData->project_id);

        if(isset($contractData->status_created_by))
        {
            $contractStatusCreated = $this->contractStatusCreated[$contractData['status_created_by']];
        }else{
            $contractStatusCreated = "";
        }
        return [
            $contractData->id,
            $contractData->name,
            $contractData->cmnd,
            $contractData->phone,
            $contractData->address,
            $contractData->household,
            $contractData->birthday,
            '',
            $contractData->contract_no,
            $contractData->area_signed,
            $contractData->type,
            $contractSigned,
            $contractData->signed_date,
            $contractData->value,
            $contractData->lot_number,
            $project->name,
            $this->contractStatus[$contractData->status],
            $contractStatusCreated,
        ];
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
            '',
            'Số hợp đồng',
            'Diện tích kí',
            'Loại hợp đồng',
            'Đã kí hay chưa	',
            'Ngày kí',
            'Giá bán',
            'Mã lô',
            'Dự án' ,
            'Trạng thái hợp đồng',
            'Giữ chỗ' ,
        ];
    }



    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,

            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'N' => NumberFormat::FORMAT_NUMBER,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,

        ];
    }

}
