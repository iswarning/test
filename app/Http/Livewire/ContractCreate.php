<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contracts;
use App\Models\Payment;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
use App\Models\Project;
use App\Enums\ContractInfo;
use App\Enums\BookHolder;
use Illuminate\Validation\Rule;

class ContractCreate extends Component
{
    public $contractId = null;
    public $customerId = null;
    public $contractData = [
        'signed' => false ,
    ];
    public $contractStatus = [];
    public $contractStatusCreated = [];
    public $paymentData = [];
    
    // public $modalShowContractVisible = true;

    public function rules()
    {
        return [
            'paymentData.payment_progress' => 'required' ,
            'contractData.contract_no' => ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)] ,
            'contractData.type' => 'required' ,
            'contractData.status' => 'required' ,
            'contractData.lot_number' => 'required' ,
            'contractData.area_signed' => 'required' ,
            'contractData.value' => 'required' ,
            'contractData.project_id' => 'required' ,
            'contractData.signed_date' => 'required' ,
        ];
    }

    public function messages()
    {
        return [
            'paymentData.payment_progress.required' => 'Không thể để trống tiến độ thanh toán',
            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.status.required' => 'Không thể để trống trạng thái',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.value.required' => 'Không thể để trống giá bán',
            'contractData.project_id.required' => 'Không thể để trống dự án',
            'contractData.signed_date.required' => 'Không thể để trống ngày ký',
            'contractData.signed.required' => 'Không thể để trống' ,
        ];
    }

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
    }

    public function render()
    {
        return view('livewire.contract-create', [
            'projects' => Project::all() ,
        ]);
    }

    public function createShowModalContract()
    {
        // dd($this->customerId);
        // $this->reset();
        $this->contractId = null;
        $this->contractData = [
            'signed' => false ,
            'status_created_by' => null,
            'status' => null
        ];
        $this->payment_date_95 = null;
        $this->payment_progress = null;
        $this->modalShowContractVisible = true;
        dd($this->modalShowContractVisible);
    }

    public function createContract()
    {
        $this->contractData['customer_id'] = $this->customerId;
        $this->validate();
        $contract = Contracts::create($this->contractData);
        if(isset($contract)){
            $this->paymentData['payment_status'] = 0;
            $this->contractId = $contract->id;
            $this->paymentData['contract_id'] = $this->contractId;
            Payment::create($this->paymentData);
        }
        // $this->modalShowContractVisible = false;
        session()->flash('message', 'Tạo hợp đồng thành công!');
    }
}
