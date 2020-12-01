<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contracts;
use App\Models\Payment;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
use App\Enums\ContractInfo;
use App\Enums\BookHolder;
use App\Http\Livewire\CustomerDetail;

class ContractDetail extends Component
{
    public $contractId;
    public $customerId;

    public $modalShowContractVisible = false;

    public $contractStatus;
    public $contractStatusCreated = [];
    public $contractInfo = [];
    public $bookHolder = [];

    public $projectData = [];
    public $contractItem = [
        'signed' => false
    ];

    public function rules()
    {
        return [
            'contractData.contract_no' => ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)],
            'contractData.type' => 'required',
            'contractData.status' => 'required',
            'contractData.lot_number' => 'required',
            'contractData.area_signed' => ['required', 'numeric'],
            'contractData.value' => 'required',
            'contractData.project_id' => 'required',
            'contractData.signed_date' => 'required',
            'contractData.signed' => 'required',
            'paymentData.payment_date_95' => 'required',
            'paymentData.payment_progress' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customerData.name.required' => 'Không thể để trống tên',
            'customerData.cmnd.required' => 'Không thể để trống cmnd',
            'customerData.cmnd.unique' => 'Cmnd đã tồn tại',
            'customerData.address.required' => 'Không thể để trống địa chỉ',
            'customerData.household.required' => 'Không thể để trống hộ khẩu',
            'customerData.birthday.required' => 'Không thể để trống ngày sinh',
            'customerData.phone.required' => 'Không thể để trống số điện thoại',
            'customerData.phone.numeric' => 'Số điện thoại phải là số',

            'paymentData.payment_date_95.required' => 'Không thể để trống ngày thanh toán đủ 95%',
            'paymentData.payment_progress.required' => 'Không thể để trống giá bán tiến độ thanh toán',
        ];
    }

    public function mount($id)
    {
        $this->contractId = $id;
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
        $this->bookHolder = BookHolder::roleName;
        $this->contractInfo = ContractInfo::infoName;

    }

    public function render()
    {
        return view('livewire.contract-detail', [
            'contract' => Contracts::find($this->contractId)
        ]);

    }

    public function createShowContract()
    {
        $this->resetValidation();
        $this->contractItem = [];
        $this->contractId = null;
        $this->modalShowContractVisible = true;
    }

    public function createContract()
    {
        $this->contractData['customer_id'] = $this->customerId;
        $this->validate();
        $contracts = Contracts::create($this->contractData);
        $this->contractId = $contracts['id'];

        $this->paymentData['contract_id'] = $this->contractId;
        Payment::create($this->paymentData);

        $this->modalShowContractVisible = false;
        $this->resetPage();
        session()->flash('message', 'Tạo hợp đồng thành công!');
    }

//    public function updateShowContract()
//    {
////        $this->resetValidation();
////        $this->contractId = $id;
////        $this->projectData = Project::all();
////        $this->contractData = Contracts::find($id)->toArray();
////        $this->modalShowContractVisible = true;
//        dd('working');
//    }

    public function updateShowContract()
    {
        dd('sssss');
    }

    public function updateContract()
    {
        $this->contractData['id'] = $this->contractId;
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Cap nhat thong tin hop dong thanh cong');
    }
}
