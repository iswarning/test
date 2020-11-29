<?php

namespace App\Http\Livewire;

use App\Models\Customers as ModelsCustomers;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Models\Contracts;
use App\Enums\ContractStatus;
use App\Models\Project;
use App\Models\Payment;
use App\Enums\ContractStatusCreated;

class Customers extends Component
{

    use WithPagination;

    public $customerId;
    public $contractId;
    public $keyWord;
    public $recordNum = 20;
    public $dataTableHistoryVisible = false;
    public $dataTableCustomerVisible = true;
    public $modalConfirmDeleteVisible = false;
    public $modalFormCustomerVisible = false;
    public $modalFormContractVisible = false;
    public $customerData = [];
    public $historyData = [];
    protected $paginationTheme = 'bootstrap';

    // History
    public $dataNotUpdate;
    public $dataUpdated;

    // Contract
    public $projectData = [];
    public $paymentData = [];
    public $modalFormVisible = false;
    public $contractStatus = [];
    public $contractStatusCreated = [];
    public $contractData = [
        'signed' => false,
        'status' => 0
    ];

    public function rules()
    {
        return [
            'customerData.name' => 'required',
            'customerData.cmnd' => ['required', Rule::unique('customers', 'cmnd')->ignore($this->customerId)],
            'customerData.birthday' => 'required',
            'customerData.household' => 'required',
            'customerData.address' => 'required',
            'customerData.phone' => 'required',
            'contractData.contract_no' => ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)],
            'contractData.type' => 'required',
            'contractData.lot_number' => 'required',
            'contractData.area_signed' => ['required', 'numeric'],
            'contractData.value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customerData.name.required' => 'Không thể để trống họ tên',
            'customerData.cmnd.required' => 'Không thể để trống chứng minh nhân dân',
            'customerData.cmnd.unique' => 'Chứng minh nhân dân đã tồn tại',
            'customerData.birthday.required' => 'Không thể để trống ngày sinh',
            'customerData.household.required' => 'Không thể để trống hộ khẩu',
            'customerData.address.required' => 'Không thể để trống địa chỉ',
            'customerData.phone.required' => 'Không thể để trống số điện thoại',
            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.value.required' => 'Không thể để trống giá bán'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->validate();
        $customer = ModelsCustomers::create($this->customerData);
        $this->contractData['customer_id'] = $customer->id;
        $contract = Contracts::create($this->contractData);
        $this->paymentData['contract_id'] = $contract->id;
        Payment::create($this->paymentData);
        $this->modalFormVisible = false;
        session()->flash('message', 'Lưu thông tin khách hàng thành công!');
    }

    public function update()
    {
        $this->validate();
        ModelsCustomers::find($this->customerId)->update($this->customerData);
        $this->modalFormVisible = false;
        $this->dataUpdated = ModelsCustomers::find($this->customerId);
        Contracts::find($this->contractId)->update($this->contractData);
        $this->checkUpdate($this->dataNotUpdate, $this->dataUpdated);
        session()->flash('message', 'Cập nhật thông tin khách hàng thành công!');
    }

    public function delete()
    {
        ModelsCustomers::destroy($this->customerId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    public function render()
    {
        $searchKey = '%' . $this->keyWord . '%';
        return view('livewire.customers', [
            'customers' => ModelsCustomers::whereHas('contracts',function ($query) use ($searchKey) {
                $query->where('name', 'like', $searchKey)
                    ->orWhere('cmnd', 'like', $searchKey)
                    ->orWhere('phone', 'like', $searchKey);
            })->with('contracts', function($query) use ($searchKey){
                $query->where('contract_no','like', $searchKey)
                    ->orWhere('lot_number','like', $searchKey);
            })->paginate($this->recordNum) ,

            'histories' => History::orderBy('id', 'desc')->paginate($this->recordNum) ,
            'projects' => Project::all()
        ]);




        // $searchKey = '%' . $this->keyWord . '%';
        // $customers = ModelsCustomers::whereHas('contracts', function ($query) use ($searchKey){
        //     $query->where('name', 'like', '%'.$searchKey.'%')
        //         ->orWhere('cmnd', 'like', '%'.$searchKey.'%');
        // })->with(['contracts' => function($query) use ($searchKey){
        //     $query->where('project_id', 'like', '%'.$searchKey.'%')
        //         ->orWhere('lot_number', 'like', '%'.$searchKey.'%')
        //         ->orWhere('status_created_by', 'like', '%'.$searchKey.'%');
        // }])->get();


        // foreach($customers as $customer)
        // {
        //     foreach($customer->contracts as $contract)
        //     {

        //         echo $contract->project_id;
        //     }
        // }

    }

    /**
     * Show the form modal
     * of the create function
     *
      * @return void
     */
    public function createShowModal()
    {
        $this->reset();
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
        $this->modalFormContractVisible = false;
        $this->modalFormCustomerVisible = true;
    }

    public function updateShowModal($customer_id, $contract_id)
    {
        $this->dataNotUpdate = ModelsCustomers::findOrFail($customer_id);
        $this->resetValidation();
        $this->customerId = $customer_id;
        $this->contractId = $contract_id;
        $this->modalFormCustomerVisible = true;
        $this->modalFormContractVisible = false;
        $this->customerData = ModelsCustomers::find($this->customerId)->toArray();
        $this->contractData = Contracts::find($this->contractId)->toArray();
    }

    public function deleteShowModal($id)
    {
        $this->customerId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function historyShowModal()
    {
        $this->dataTableCustomerVisible = false;
        $this->dataTableHistoryVisible = true;
    }

    public function checkUpdate($a, $b)
    {
        // Check name
        if($b->name != $a->name)
        {
            $this->createHistory(" Name: ".$b->name);
        }

        // Check cmnd
        if($b->cmnd != $a->cmnd)
        {
            $this->createHistory(" CMND: ".$b->cmnd);
        }

        // Check address
        if($b->address != $a->address)
        {
            $this->createHistory(" Address: ".$b->address);
        }

        // Check birthday
        if($b->birthday != $a->birthday)
        {
            $this->createHistory(" Birthday: ".$b->birthday);
        }

        // Check household
        if($b->household != $a->household)
        {
            $this->createHistory(" HouseHold: ".$b->household);
        }

        // Check phone
        if($b->phone != $a->phone)
        {
            $this->createHistory(" Phone: ".$b->phone);
        }

    }

    public function createHistory($target)
    {
        History::create([
            'title' => Auth::user()->name." has changed ".$target
        ]);
    }

    public function nextModal()
    {

        $this->modalFormContractVisible = true;
        $this->modalFormCustomerVisible = false;
    }

    public function backModal()
    {
        $this->modalFormCustomerVisible = true;
        $this->modalFormContractVisible = false;
    }

}
