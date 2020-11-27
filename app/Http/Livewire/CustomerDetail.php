<?php

namespace App\Http\Livewire;

use App\Enums\ContractStatus;
use App\Models\Contracts;
use App\Models\Customers;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Payment;
use App\Enums\ContractInfo;
use App\Models\Juridical;
use App\Enums\BookHolder;


class CustomerDetail extends Component
{
    use WithPagination;

    public $contractId;
    

    public $customerId;   
    public $juridicalId;
    public $paymentId;

    public $customerData;
    public $paymentData;
    public $projectData;

    public $modalFormVisible = false;
    public $modalFormJuridicalVisible = false;
    public $modalShowContractVisible = false;
    public $modalShowPaymentVisible = false;
    public $modalShowJuridicalVisible = false;
    public $modalvisible = false;

    public $contractStatus;
    public $contractInfo = [];
    public $bookHolder = [];
    public $juridicalData = [];
    public $contractData = [
        'signed' => false
    ];
    protected $paginationTheme = 'bootstrap';

    public $tab = 'customer';

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
            'paymentData.payment_date_95' => 'required',
            'paymentData.payment_progress' => 'required',
            'contractData.signed' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.value.required' => 'Không thể để trống giá bán'
        ];
    }

    public function mount($id)
    {
        $this->customerId = $id;
        // Get customer data
        $this->customerData = Customers::find($id);
        // Get project data for dropdown
        $this->projectData = Project::all();

        $this->contractStatus = ContractStatus::statusName;
        $this->contractInfo = ContractInfo::infoName;
        $this->bookHolder = BookHolder::roleName;

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.customer-detail', [
            'contract' => Contracts::where('customer_id',$this->customerId)->get()
            ]);
    }

    public function createContractShowModal()
    {
        $this->contractData = [];
        // Set value for contract data
        // $this->contractData['status'] = array_key_first($this->contractStatus);
        $this->contractData['customer_id'] = $this->customerId;
        $this->contractData['project_id'] = $this->projectData->first()->id;
        $this->modalFormVisible = true;
    }

    public function updateContractShowModal($id)
    {
        $this->resetValidation();
        $this->contractId = $id;
        $this->modalFormVisible = true;
        $this->contractData = Contracts::find($this->contractId)->toArray();
    }

    public function create()
    {
        $this->validate();
        Contracts::create($this->contractData);
        // Hide modal
        $this->modalFormVisible=false;
        session()->flash('message', 'Tạo hợp đồng thành công!');
    }

    public function update()
    {
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalFormVisible=false;
        session()->flash('message', 'Cập nhật hợp đồng thành công!');
    }
    
    public function tabChange($tab, $id)
    {
        $this->tab = $tab;
        $this->contractId = $id;
                    
        $this->paymentData = Payment::where('contract_id',$this->contractId)->first();
        $this->juridicalData = Juridical::where('contract_id', $this->contractId)->first();
    }

    public function createShowJuridical()
    {
        $this->reset();
        $this->modalFormJuridicalVisible = true;       
    }

    public function createJuridical($id)
    {
        $this->validate();
        $this->contractId = $id;
        $this->juridicalData['contract_id'] = $this->contractId;
        Juridical::create($this->juridicalData);
        $this->modalFormJuridicalVisible = false;
        session()->flash('message', 'Thêm thông tin pháp lý thành công');
    }

    public function updateShowContract($id)
    {
        $this->resetValidation();
        $this->contractId = $id;
        $this->projectData = Project::all();
        $this->modalShowContractVisible = true;
        $this->contractData = Contracts::find($id)->toArray();
    }

    public function updateContract()
    {
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Cap nhat thong tin hop dong thanh cong');
    }

    public function updateShowPayment($id)
    {
        $this->resetValidation();
        $this->paymentId = $id;
        $this->paymentData = Payment::find($this->paymentId)->toArray();
        $this->modalShowPaymentVisible = true;
        
    }

    public function updatePayment()
    {
        $this->validate();
        Payment::find($this->paymentId)->update($this->paymentData);
        $this->modalShowPaymentVisible = false;
        session()->flash('message', 'Cap nhat thong tin thanh toan thanh cong');
    }

    public function updateShowJuridical($id)
    {
        $this->resetValidation();
        // $this->juridicalId = $id;
        // $this->juridicalData = Juridical::find($this->juridicalId)->toArray();
        $this->modalFormJuridicalVisible = true;  
    }

    public function updateJuridical()
    {
        $this->validate();
        Juridical::find($this->juridicalId)->update($this->juridicalData);
        $this->modalFormJuridicalVisible = false;
        session()->flash('message', 'Cap nhat thong tin phap ly thanh cong');
    }
}
