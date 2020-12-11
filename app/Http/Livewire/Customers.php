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
use Illuminate\Validation\Rules\RequiredIf;

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
        'signed' => false ,
        'status' => null
    ];

    public function rules()
    {
        $rules = [
            'paymentData.payment_progress' => 'required' ,

            'contractData.contract_no' => ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)],
            'contractData.type' => 'required',
            'contractData.status' => 'required',
            'contractData.status_created_by' => new RequiredIf($this->contractData['status'] != 2) ,
            'contractData.lot_number' => 'required',
            'contractData.area_signed' => 'required|max:4',
            'contractData.value' => 'required',
            'contractData.project_id' => 'required',
            'contractData.signed_date' => 'required',
            'contractData.signed' => 'required',
            'contractData.project_id' => 'required' ,

            'customerData.name' => 'required',
            'customerData.cmnd' => ['required', Rule::unique('customers', 'cmnd')->ignore($this->customerId)],
            'customerData.birthday' => 'required',
            'customerData.household' => 'required',
            'customerData.address' => 'required',
            'customerData.phone' => ['required','min:10','max:12'],

        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'paymentData.payment_progress.required' => 'Không thể để trống tiến độ' ,
            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.status.required' => 'Không thể để trống trạng thái',
            'contractData.status_created_by.required' => 'Không thể để trống giữ chỗ',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.area_signed.max' => 'Diện tích ký quá lớn',
            'contractData.value.required' => 'Không thể để trống giá bán',
            'contractData.project_id.required' => 'Không thể để trống dự án',
            'contractData.signed_date.required' => 'Không thể để trống ngày ký',
            // 'contractData.signed_date.date_format' => 'Ngày ký không hợp lệ',
            'contractData.signed.required' => 'Không thể để trống' ,

            'customerData.name.required' => 'Không thể để trống họ tên',
            'customerData.cmnd.required' => 'Không thể để trống chứng minh nhân dân',
            'customerData.cmnd.unique' => 'Chứng minh nhân dân đã tồn tại',
            'customerData.birthday.required' => 'Không thể để trống ngày sinh',
            // 'customerData.birthday.date_format' => 'Ngày sinh không hợp lệ',
            'customerData.household.required' => 'Không thể để trống hộ khẩu',
            'customerData.address.required' => 'Không thể để trống địa chỉ',
            'customerData.phone.required' => 'Không thể để trống số điện thoại',
            'customerData.phone.min' => 'Số điện thoại ít nhất 10 số',
            'customerData.phone.max' => 'Số điện thoại quá dài',
        ];
    }

    public function ifSelectedDefault()
    {
        if(isset($this->contractData['status']) && $this->contractData['status'] == "Chọn trạng thái"){
            $this->contractData['status'] = null;
        }
        if(isset($this->contractData['status_created_by']) && $this->contractData['status_created_by'] == "Chọn giữ chỗ"){
            $this->contractData['status_created_by'] = null;
        }
        if(isset($this->contractData['project_id']) && $this->contractData['project_id'] == 0){
            $this->contractData['project_id'] = null;
        }
    }

    public function ifDatedDefault()
    {
        if(isset($this->paymentData['payment_date_95']) && $this->paymentData['payment_date_95'] == ""){
            $this->paymentData['payment_date_95'] = null;
        }
        if(isset($this->contractData['signed_date']) && $this->contractData['signed_date'] == ""){
            $this->contractData['signed_date'] = null;
        }
    }

    public function create()
    {
        $this->ifSelectedDefault();
        $this->ifDatedDefault();
        $this->validate();

        $customer = ModelsCustomers::create($this->customerData);
        $this->contractData['customer_id'] = $customer->id;
        
        $contract = Contracts::create($this->contractData);
        if($this->paymentData['payment_date_95'] == ""){
            $this->paymentData['payment_date_95'] = null;
        }
        $this->paymentData['contract_id'] = $contract->id;
        $this->paymentData['payment_status'] = 0;
        // dd($this->paymentData);
        Payment::create($this->paymentData);
        $this->modalFormContractVisible = false;
        $this->modalFormCustomerVisible = false;
        session()->flash('message', 'Lưu thông tin khách hàng thành công!');
    }

    public function update()
    {
        $this->ifDatedDefault();
        $this->ifSelectedDefault();
        $this->validate();
        ModelsCustomers::find($this->customerId)->update($this->customerData);
        $this->dataUpdated = ModelsCustomers::find($this->customerId)->toArray();
        Contracts::find($this->contractId)->update($this->contractData);
        $payment = Payment::where('contract_id',$this->contractId)->first();
        Payment::find($payment->id)->update($this->paymentData);
        $this->checkUpdateCustomer($this->dataNotUpdate, $this->dataUpdated);
        // dd($this->paymentData);
        $this->modalFormContractVisible = false;
        $this->modalFormCustomerVisible = false;
        session()->flash('message', 'Cập nhật thông tin khách hàng thành công!');
    }

    public function delete()
    {
        Contracts::findOrFail($this->contractId)->delete();
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
        session()->flash('message','Xóa thông tin khách hàng thành công');
    }

    public function confirmDelete($id)
    {
        $this->contractId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    public function render()
    {
        $searchKey = '%' . $this->keyWord . '%';
        $customers = Contracts::join('customers','customers.id','contracts.customer_id')
            ->join('payments','payments.contract_id','contracts.id')
            ->join('projects','projects.id','contracts.project_id')
            ->where(function ($query) use ($searchKey){
                $query->where('customers.name','like',$searchKey)
                    ->orWhere('cmnd','like',$searchKey)
                    ->orWhere('phone','like',$searchKey)
                    ->orWhere('lot_number','like',$searchKey)
                    ->orWhere('contract_no','like',$searchKey)
                    ->orWhere('projects.name','like',$searchKey)
                    ->orWhere('customers.id','like',$searchKey);
            });

        if($this->selectStatus != null && $this->selectStatus === "Chọn trạng thái"){
            $this->selectStatus = null;
        }
        if($this->selectStatus != null)
        {
            $customers->where('contracts.status','=', $this->selectStatus);
        }
        

        if($this->selectBill != null && $this->selectBill === "Chọn thanh toán"){
            $this->selectBill = null;
        }
        if($this->selectBill != null)
        {
            $customers->where('payments.payment_status','=', $this->selectBill);
        }else{
            $this->selectBill = null;
        }
       
        if($this->selectTimeFrom != null)
        {
            $customers->where('contracts.created_at','>=', $this->selectTimeFrom . " 00:00:00");
            // dd($this->selectTimeFrom);
            // dd($this->selectTimeFrom);
        }
        if($this->selectTimeTo != null)
        {
            $customers->where('contracts.created_at','<=', $this->selectTimeTo . " 23:59:59");
            // dd($this->selectTimeTo);
        }

        // if($this->selectTimeFrom != null && $this->selectTimeTo != null && $this->selectTimeFrom == $this->selectTimeTo)
        // {
        //     $customers->where('contracts.created_at','>', $this->selectTimeTo);
        // }
        
        

        return view('livewire.customers', [
            'customers' => $customers
                ->select('*',
                    'projects.name as projectName',
                    'customers.name as customerName',
                    'customers.id as customerID',
                    'contracts.id as contractID',
                    'contracts.status as contractStatus' ,
                    'contracts.created_at as contractCreated'
                )
                ->paginate($this->recordNum),
            'projects' => Project::all() ,
            'histories' => History::orderBy('id','desc')->paginate(20) ,
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
        // dd($this->contractId);
        $this->customerData = ModelsCustomers::find($this->customerId)->toArray();
        $this->contractData = Contracts::find($this->contractId)->toArray();
        $this->paymentData = Payment::where('contract_id', $this->contractId)->first()->toArray();
        $this->modalFormCustomerVisible = true;
        $this->modalFormContractVisible = false;
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

    public function checkUpdateCustomer($a, $b)
    {
        // Check Name
        if($b['name'] != $a['name'])
        {
            $this->createHistoryCustomer(" Họ tên: ".$b['name'], $b['id']);
        }
        // Check Cmnd
        if($b['cmnd'] != $a['cmnd'])
        {
            $this->createHistoryCustomer(" Cmnd: ".$b['cmnd'], $b['id']);
        }
        // Check Phone
        if($b['phone'] != $a['phone'])
        {
            $this->createHistoryCustomer(" Số điện thoại: ".$b['phone'], $b['id']);
        }
        // Check Household
        if($b['household'] != $a['household'])
        {
            $this->createHistoryCustomer(" Hộ khẩu: ".$b['household'], $b['id']);
        }
        // Check Birthday
        if($b['birthday'] != $a['birthday'])
        {
            $this->createHistoryCustomer(" Ngày sinh: ".$b['birthday'], $b['id']);
        }
        if($b['address'] != $a['address'])
        {
            $this->createHistoryCustomer(' Địa chỉ: '.$b['address'], $b['id']);
        }
    }

    public function createHistoryCustomer($target, $id)
    {
        History::create([
            'title' => Auth::user()->name." đã thay đổi ".$target ,
            'customer_id' => $id
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
