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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;
use App\Exports\CustomerPDF;
use App\Http\Controllers\TestController;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Revisions;

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
    public $customerExport = [];
    protected $paginationTheme = 'bootstrap';

    // History
    public $dataNotUpdate = [];
    public $dataUpdated = [];

    // Contract
    public $selectTimeFrom;
    public $selectTimeTo;
    public $selectBill;
    public $selectStatus = null;
    public $selectProject = 0;
    public $countContract;
    public $countCustomer;
    public $dataPDF;


    public $projectData = [];
    public $paymentData = [];
    public $modalFormVisible = false;
    public $contractStatus = [];
    public $contractStatusCreated = [];
    public $contractData = [
        'signed' => false ,
        'status' => null,
        'status_created_by' => null,
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
            'contractData.project_id' => 'required' ,

            'customerData.name' => 'required',
            'customerData.cmnd' => ['required', Rule::unique('customers', 'cmnd')->ignore($this->customerId)],
            'customerData.birthday' => [
                'required',
                'date_format:Y-m-d', 
                'before:' . date('Y-m-d')],
            'customerData.household' => 'required',
            'customerData.address' => 'required',
            'customerData.phone' => ['required','min:10','max:12'],

        ];
        if($this->contractData['status'] == 2){
            $rules['contractData.status_created_by'] = 'required';
        }
        
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
            'customerData.birthday.date_format' => 'Ngày sinh không hợp lệ',
            'customerData.birthday.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại'
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

        // dd($this->contractData);
        $customer = ModelsCustomers::create($this->customerData);
        $this->contractData['customer_id'] = $customer->id;
        
        $contract = Contracts::create($this->contractData);
        if(isset($this->paymentData['payment_date_95']) && $this->paymentData['payment_date_95'] == ""){
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
        if($this->contractData['status'] == 2){
            $this->contractData['status_created_by'] = null;
        }
        ModelsCustomers::find($this->customerId)->update($this->customerData);
        $this->dataUpdated = ModelsCustomers::find($this->customerId)->toArray();
        Contracts::find($this->contractId)->update($this->contractData);
        $payment = Payment::where('contract_id',$this->contractId)->first();
        $revision = Revisions::where('revisionable_id','=',$this->contractId)->get();
        foreach($revision as $r){
            Revisions::find($r['id'])->update([
                'revisionable_id' => $this->customerId
            ]);
        }
        
        Payment::find($payment->id)->update($this->paymentData);
        // $this->checkUpdateCustomer($this->dataNotUpdate, $this->dataUpdated);
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

        if($this->selectStatus != null && empty($this->selectStatus)){
            $this->selectStatus = null;
        }
        if($this->selectStatus != null)
        {
            $customers->where('contracts.status','=', $this->selectStatus);
        }
        

        if($this->selectBill != null && empty($this->selectBill)){
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
            $customers->where('contracts.signed_date','>=', $this->selectTimeFrom . " 00:00:00");
        }
        if($this->selectTimeTo != null)
        {
            $customers->where('contracts.signed_date','<=', $this->selectTimeTo . " 23:59:59");
            // dd($this->selectTimeTo);
        }

        if($this->selectProject != 0){
            $customers->where('contracts.project_id','=', $this->selectProject);
        }
        
        $customerExport = $customers->select('*',
            'projects.name as projectName',
            'customers.name as customerName',
            'customers.id as customerID',
            'contracts.id as contractID',
            'contracts.status as contractStatus' ,
            'contracts.created_at as contractCreated',
            'payments.id as paymentId',
        );

        $dataRender = $customerExport->orderBy('customers.name', 'asc')->paginate($this->recordNum);
        // dd($dataRender);
        $this->customerExport = $dataRender->toArray();
        $this->countContract = count($dataRender);
        $this->countCustomer = count(ModelsCustomers::all());
        
        if(!empty($this->keyWord) || $this->selectStatus != null || $this->selectBill != null || $this->selectTimeFrom != null || $this->selectTimeTo != null || $this->selectProject != 0){
            $this->countCustomer = $this->countContract;
            for($i = 0; $i < count($dataRender); $i++){
                    if($i != 0){
                        if($dataRender[$i]->customerID == $dataRender[$i-1]->customerID){
                            $this->countCustomer--;
                    }
                }  
            }
        }
        
        // $test = new CustomerPDF($dataRender);
        // $test->exportPDF();
        $historires = DB::table('revisions')->get();
        $convertEnToVi = [
            'name' => 'Tên',
            'address' => 'Địa chỉ',
            'household' => 'Hộ Khẩu',
            'birthday' => 'Ngày sinh',
            'phone' => 'Số điện thoại',

            'contract_no' => 'Số hợp đồng',
            'area_signed' => 'Diện tích ký',
            'type' => 'Loại hợp đồng',
            'signed' => 'Trạng thái ký',
            'signed_date' => 'Ngày ký',
            'value' => 'Giá bán',
            'lot_number' => 'Mã lô',
            'status' => 'Trạng thái hợp đồng',
            'project_id' => 'Dự án',
            'status_created_by' => 'Giữ chỗ',

            'payment_progress' => 'Tiến độ thanh toán',
            'payment_date_95' => 'Ngày thanh toán 95%',

            'day_late' => 'Ngày trễ',
            'batch_late' => 'Đợt trễ',
            'money_late' => 'Tiền trễ',
            'citation_rate' => 'Lãi phạt',
            'number_notifi' => 'Số lần đã gửi thông báo',
            'document' => 'Văn bản , phương thức',
            'receipt_date' => 'Ngày khách nhận thông báo',

            'contract_info' => 'Thông tin hợp đồng',
            'status' => 'Tình trạng sổ',
            'notarized_date' => 'Ngày công chứng',
            'registration_procedures' => 'Thủ tục đăng bộ',
            'delivery_book_date' => 'Ngày bàn giao sổ',
            'liquidation' => 'Thanh lý hợp đồng',
            'bill_profile' => 'Hồ sơ thu lại của khách hàng',
            'book_holder' => 'Bộ phận giữ sổ',
            'delivery_land_date' => 'Ngày bàn giao đất',
            'commitment' => 'Cam kết thỏa thuận',
        ];

        return view('livewire.customers', [
            'customers' => $dataRender,
            'projects' => Project::all() ,
            'histories' => $historires,
            'convert' => $convertEnToVi
        ]);
    }

    public function mount()
    {
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
    }

    public function createShowModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
        $this->modalFormContractVisible = false;
        $this->modalFormCustomerVisible = true;

    }

    public function updateShowModal($customer_id, $contract_id)
    {
         // $this->reset();
        $this->dataNotUpdate = ModelsCustomers::find($customer_id)->toArray();
        // $this->contractStatus = ContractStatus::statusName;
        // $this->contractStatusCreated = ContractStatusCreated::statusName;
        $this->resetValidation();
        $this->customerId = $customer_id;
        $this->contractId = $contract_id;
        // dd($this->contractId);
        $this->customerData = ModelsCustomers::find($this->customerId)->toArray();
        if(isset($this->customerData['status_created_by']) && $this->customerData['status_created_by'] == 0){
            $this->customerData['status_created_by'] = null;
        }
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

    // public function checkUpdateCustomer($a, $b)
    // {
    //     // Check Name
    //     if($b['name'] != $a['name'])
    //     {
    //         $this->createHistoryCustomer(" Họ tên: ".$b['name'], $b['id']);
    //     }
    //     // Check Cmnd
    //     if($b['cmnd'] != $a['cmnd'])
    //     {
    //         $this->createHistoryCustomer(" Cmnd: ".$b['cmnd'], $b['id']);
    //     }
    //     // Check Phone
    //     if($b['phone'] != $a['phone'])
    //     {
    //         $this->createHistoryCustomer(" Số điện thoại: ".$b['phone'], $b['id']);
    //     }
    //     // Check Household
    //     if($b['household'] != $a['household'])
    //     {
    //         $this->createHistoryCustomer(" Hộ khẩu: ".$b['household'], $b['id']);
    //     }
    //     // Check Birthday
    //     if($b['birthday'] != $a['birthday'])
    //     {
    //         $this->createHistoryCustomer(" Ngày sinh: ".$b['birthday'], $b['id']);
    //     }
    //     if($b['address'] != $a['address'])
    //     {
    //         $this->createHistoryCustomer(' Địa chỉ: '.$b['address'], $b['id']);
    //     }
    // }

    // public function createHistoryCustomer($target, $id)
    // {
    //     History::create([
    //         'title' => Auth::user()->name." đã thay đổi ".$target ,
    //         'customer_id' => $id
    //     ]);
    // }

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

    public function export(){
        // dd($this->customerExport);
        return Excel::download(new CustomerExport($this->customerExport), 'customers.xlsx');
    }


    public function exportPDF()
    {
        // return PDF::download(new CustomerPDF($this->customerExport['data']), 'customers.pdf');
        $pdf = PDF::loadView('exportPDF', ['customers' => $this->customerExport['data']])->output();
        return response()->streamDownload(
            function() use ($pdf){
                return print($pdf);
            },
            'customers.pdf'
        );
        // set_time_limit(300);
    }
}
