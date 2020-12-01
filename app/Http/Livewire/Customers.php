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
use App\Models\Juridical;
use App\Enums\ContractStatusCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public $dataNotUpdate = [];
    public $dataUpdated = [];

    // Contract
    public $selectTimeFrom;
    public $selectTimeTo;
    public $selectBill;
    public $selectStatus;


    public $projectData = [];
    public $paymentData = [];
    public $modalFormVisible = false;
    public $contractStatus = ContractStatus::statusName;
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

    public function updated()
    {

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
        $this->dataUpdated = ModelsCustomers::find($this->customerId)->toArray();
        Contracts::find($this->contractId)->update($this->contractData);
        Payment::where('contract_id',$this->contractId)->update($this->paymentData);
        $this->checkUpdateCustomer($this->dataNotUpdate, $this->dataUpdated);

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
        if($this->selectStatus != null)
        {
            return view('livewire.customers', [
                'customers' => Contracts::join('customers','customers.id','contracts.customer_id')
                    ->join('payments','payments.contract_id','contracts.id')
                    ->join('projects','projects.id','contracts.project_id')
                    ->where('contracts.status','=', $this->selectStatus)
                    ->select('*',
                        'projects.name as projectName',
                        'customers.name as customerName',
                        'customers.id as customerID',
                        'contracts.id as contractID',
                        'contracts.status as contractStatus'
                    )
                    ->get() ,
                'projects' => Project::all() ,
                'histories' => History::all()
            ]);
        }
        return view('livewire.customers', [
            'customers' => Contracts::join('customers','customers.id','contracts.customer_id')
                ->join('payments','payments.contract_id','contracts.id')
                ->join('projects','projects.id','contracts.project_id')
                ->where('customers.name','like',$searchKey)
                ->orWhere('cmnd','like',$searchKey)
                ->orWhere('phone','like',$searchKey)
                ->orWhere('lot_number','like',$searchKey)
                ->orWhere('contract_no','like',$searchKey)
                ->orWhere('projects.name','like',$searchKey)
                ->where('contracts.status','=', $this->selectStatus)
                ->select('*',
                    'projects.name as projectName',
                    'customers.name as customerName',
                    'customers.id as customerID',
                    'contracts.id as contractID',
                    'contracts.status as contractStatus' ,
                    'contracts.created_at as contractCreated'
                )
                ->get(),
            'projects' => Project::all() ,
            'histories' => History::all()
        ]);


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
        $this->dataNotUpdate = ModelsCustomers::find($customer_id)->toArray();
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

    public function historyShowList()
    {
        $this->dataTableCustomerVisible = false;
        $this->dataTableHistoryVisible = true;
    }

    public function customerShowList()
    {
        $this->dataTableCustomerVisible = true;
        $this->dataTableHistoryVisible = false;
    }

    public function getArrayCustomer($data)
    {
        $newData = [];
        $newData[] = $data['name'];
        $newData[] = $data['cmnd'];
        $newData[] = $data['address'];
        $newData[] = $data['birthday'];
        $newData[] = $data['household'];
        $newData[] = $data['phone'];
        return $newData;
    }


    public function checkUpdateCustomer(array $a, array $b)
    {
        $dataNotUpdate = $this->getArrayCustomer($a);
        $dataUpdated = $this->getArrayCustomer($b);
        for($i = 0; $i < count($dataNotUpdate); $i++)
        {
            for($j = 0; $j < count($dataUpdated); $j++)
            {
                if($dataUpdated[$j] != $dataNotUpdate[$i])
                {
                    $this->createHistoryCustomer($dataUpdated[$j]);
                }
            }
        }
    }

    public function createHistoryCustomer($target)
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
