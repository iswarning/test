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
use App\Models\BillLate;
use App\Enums\ContractStatusCreated;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Validation\Rules\RequiredIf;

use App\Exports\CustomerPDF;
use App\Exports\CustomerExport;



class CustomerDetail extends Component
{
    use WithPagination;

    public $contractId;
    public  $customerId;
    public static $customerID;
    public $juridicalId;
    public $paymentId;
    public $billlateId;
    public $payment_progress;
    public $payment_date_95;
    public $dataUpdated;
    public $dataNotUpdate;

    public $modalShowCustomerVisible = false;
    public $modalShowContractVisible = false;
    public $modalShowPaymentVisible = false;
    public $modalShowJuridicalVisible = false;
    public $modalCreateBilllate = false;
    public $infoBillLate = false;

    public $contractStatus;
    public $contractStatusCreated = [];
    public $contractInfo = [];
    public $bookHolder = [];

    public $customerData = [];
    public $paymentData = [
        'payment_status' => 0
    ];
    public $projectData = [];
    public $billlateData = [];
    public $juridicalData = [
        'liquidation' => true ,
    ];
    public $contractData = [
        'signed' => false ,
        'status_created_by' => null,
        'status' => null
    ];
    protected $paginationTheme = 'bootstrap';

    public $tab = 'customer';

    public function rules()
    {
        $rules = [
            'customerData.name' => 'required',
            'customerData.cmnd' => ['required', Rule::unique('customers', 'cmnd')->ignore($this->customerId)],
            'customerData.address' => 'required',
            'customerData.household' => 'required',
            'customerData.birthday' => 'required|date_format:yy-m-d',
            'customerData.phone' => 'required|min:10|max:12',
        ];

        if($this->modalShowContractVisible == true)
        {
            if($this->contractId == null)
            {
                $rules = [
                    'payment_progress' => 'required' ,
                ];
            }
            $rules['contractData.contract_no'] = ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)];
            $rules['contractData.type'] = ['required',];
            $rules['contractData.status'] = 'required';
            $rules['contractData.status_created_by'] = new RequiredIf($this->contractData['status'] != 2);
            $rules['contractData.lot_number'] = ['required',];
            $rules['contractData.area_signed'] = 'required|max:4';

            $rules['contractData.value'] = 'required';
            $rules['contractData.project_id'] = 'required';
            $rules['contractData.signed_date'] = 'required|date_format:yy-m-d';

        }

        if($this->modalShowPaymentVisible == true)
        {
            if($this->billlateId != null)
            {
                $rules = [
                    'paymentData.payment_progress' => 'required',
                    'paymentData.contract_id' => 'required' ,
                ];
            }
            $rules['billlateData.day_late'] = 'required';
            $rules['billlateData.batch_late'] = 'required';
            $rules['billlateData.money_late'] = 'required';
            $rules['billlateData.citation_rate'] = 'required';
            $rules['billlateData.number_notifi'] = 'required';
            $rules['billlateData.document'] = 'required';
            $rules['billlateData.receipt_date'] = 'required|date_format:yy-m-d';
        }

        if($this->modalShowJuridicalVisible == true)
        {
            $rules = [
                'juridicalData.contract_info' => 'required',
                'juridicalData.status' => 'required',
                'juridicalData.registration_procedures' => 'required',
                'juridicalData.book_holder' => 'required',
                // 'juridicalData.book_holder' => new RequiredIf(isset($this->juridicalData['book_holder']) && $this->juridicalData['book_holder'] == "Chọn bộ phận"),
                'juridicalData.contract_id' => 'required',
                'juridicalData.notarized_date' => 'nullable'
            ];
        }

        return $rules;
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
            'customerData.birthday.date_format' => 'Không thể để trống ngày sinh',
            'customerData.phone.required' => 'Không thể để trống số điện thoại',
            'customerData.phone.min' => 'Số điện thoại ít nhất 10 số',
            'customerData.phone.max' => 'Số điện thoại quá dài',

            'paymentData.payment_progress.required' => 'Không thể để trống tiến độ thanh toán',
            'payment_progress.required' => 'Không thể để trống tiến độ thanh toán',

            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.status.required' => 'Không thể để trống trạng thái',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.area_signed.max' => 'Diện tích ký quá lớn',
            'contractData.value.required' => 'Không thể để trống giá bán',
            'contractData.project_id.required' => 'Không thể để trống dự án',
            'contractData.signed_date.required' => 'Không thể để trống ngày ký',
            'contractData.signed_date.date_format' => 'Ngày ký không hợp lệ',
            'contractData.signed.required' => 'Không thể để trống' ,

            'billlateData.day_late.required' => 'Không thể để trống ngày trễ',
            'billlateData.batch_late.required' => 'Không thể để trống đợt trễ',
            'billlateData.money_late.required' => 'Không thể để trống số tiền trễ',
            'billlateData.citation_rate.required' => 'Không thể để trống lãi phạt',
            'billlateData.number_notifi.required' => 'Không thể để trống số lần đã thông báo',
            'billlateData.document.required' => 'Không thể để trống văn bản',
            'billlateData.receipt_date.required' => 'Không thể để trống ngày khách nhận thông báo',
            'billlateData.receipt_date.date_format' => 'Ngày khách nhận thông báo không hợp lệ',

            'juridicalData.status.required' => 'Không thể để trống trạng thái',
            'juridicalData.registration_procedures.required' => 'Không thể để trống thủ tục đăng bộ',
            'juridicalData.book_holder.required' => 'Không thể để trống bộ phận' ,
            'juridicalData.contract_info.required' => 'Không thể để trống hợp đồng' ,
        ];
    }

    public function mount($id)
    {
        $this->customerId = $id;
        $this->customerData = Customers::find($this->customerId)->toArray();
        // Get project data for dropdown
        $this->projectData = Project::all();

        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
        $this->contractInfo = ContractInfo::infoName;
        $this->bookHolder = BookHolder::roleName;

    }

    public function updateShowModalCustomer($id)
    {
        $this->dataNotUpdate = Customers::find($id)->toArray();
        // $this->resetValidation();
        $this->modalShowCustomerVisible = true;
        $this->customerId = $id;
        $this->customerData = Customers::find($this->customerId)->toArray();
    }

    public function updateCustomer()
    {
        // dd($this->customerData);
        $this->validate();
        Customers::find($this->customerId)->update($this->customerData);
        $this->dataUpdated = Customers::find($this->customerId)->toArray();
        $this->checkUpdateCustomer($this->dataNotUpdate, $this->dataUpdated);
        $this->modalShowCustomerVisible = false;
        session()->flash('message', 'Cập nhật thông tin khách hàng thành công');
    }

    public function checkUpdateCustomer($a, $b)
    {
        // Check Name
        if($b['name'] != $a['name'])
        {
            $this->createHistoryCustomer(" Họ Tên: ".$b['name'], $b['id']);
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {

        return view('livewire.customer-detail', [
            'contract' =>   Contracts::where('customer_id',$this->customerId)->get(),
        ]);

    }

    public function createShowContract()
    {
        
        $this->contractId = null;
        $this->contractData = [
            'signed' => false ,
            'status_created_by' => null,
            'status' => null,
            'project_id' => 0
        ];
        // $this->payment_date_95 = null;
        // $this->payment_progress = null;
        $this->modalShowContractVisible = true;
    }

    public function createContract()
    {
        
        $this->ifSelectedDefault();
        $this->ifDatedDefault();
        $this->contractData['customer_id'] = $this->customerId;
        $this->validate();
        $contracts = Contracts::create($this->contractData);
        
        if($contracts){
            Payment::create([
                'payment_progress' => $this->payment_progress ,
                'payment_date_95' => $this->payment_date_95 ,
                'contract_id' => $contracts->id ,
                'payment_status' => 0
            ]);
        }
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Tạo hợp đồng thành công!');
    }
    

    public function tabChange($tab, $id)
    {
        $this->tab = $tab;
        $this->contractId = $id;


        $this->paymentData = Payment::where('contract_id',$this->contractId)->first();
        $this->paymentId = $this->paymentData['id'];

        $this->billlateData = BillLate::where('payment_id',$this->paymentId)->first();
        if($this->billlateData != null) {
            $this->billlateId = $this->billlateData['id'];
            $this->infoBillLate = true;
        }else{
            $this->infoBillLate = false;
            $this->billlateId= null;
        }

        $this->juridicalData = Juridical::where('contract_id', $this->contractId)->first();

        if($this->juridicalData != null) {
            $this->juridicalId = $this->juridicalData->id;
        }else{
            $this->juridicalId = null;
        }

    }

    public function createShowJuridical()
    {
        $this->resetValidation();
        $this->modalShowJuridicalVisible = true;
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
        
        if(isset($this->juridicalData['book_holder']) && $this->juridicalData['book_holder'] == "Chọn bộ phận"){
            $this->juridicalData['book_holder'] = null;
        }
        if(isset($this->juridicalData['contract_info']) && $this->juridicalData['contract_info'] == "Chọn hợp đồng"){
            $this->juridicalData['contract_info'] = null;
        }
    }

    public function ifDatedDefault()
    {
        if(isset($this->paymentData['payment_date_95']) && $this->paymentData['payment_date_95'] == ""){
            $this->paymentData['payment_date_95'] = null;
        }
        if(isset($this->payment_date_95) && $this->payment_date_95 == ""){
            $this->payment_date_95 = null;
        }
        if(isset($this->contractData['signed_date']) && $this->juridicalData['signed_date'] == ""){
            $this->contractData['signed_date'] = null;
        }
        if(isset($this->juridicalData['notarized_date']) && $this->juridicalData['notarized_date'] == ""){
            $this->juridicalData['notarized_date'] = null;
        }
        if(isset($this->juridicalData['delivery_book_date']) && $this->juridicalData['delivery_book_date'] == ""){
            $this->juridicalData['delivery_book_date'] = null;
        }
        if(isset($this->juridicalData['delivery_land_date']) && $this->juridicalData['delivery_land_date'] == ""){
            $this->juridicalData['delivery_land_date'] = null;
        }
    }

    public function createJuridical()
    {
        
        $this->ifDatedDefault();
        $this->ifSelectedDefault();
        
        $this->juridicalData['contract_id'] = $this->contractId;
        $this->juridicalData['liquidation'] = true;
        $this->validate();
        $juridical = Juridical::create($this->juridicalData);
        $this->juridicalId = $juridical->id;
        $this->modalShowJuridicalVisible = false;
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
        $this->ifDatedDefault();
        $this->ifSelectedDefault();
        $this->contractData['id'] = $this->contractId;
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Cập nhật thông tin hợp đồng thành công');
    }

    public function updateShowPaymentAndBill($id)
    {
        // dd($id);
        
        $this->paymentData = Payment::find($id)->toArray();
        // dd($this->paymentData);
        
        if(BillLate::where('payment_id',$id)->first() !== null){
            $this->billlateData = BillLate::find($this->billlateId)->toArray();
            $this->billlateId = $this->billlateData['id'];
        }
        
        // dd($this->billlateId);
       
        $this->modalShowPaymentVisible = true;
        // dd();
    }

    public function updatePaymentAndBill()
    {
        $this->ifDatedDefault();
        // $this->ifSelectedDefault();
        $this->validate([
            'paymentData.payment_progress' => 'required',
            'paymentData.payment_date_95' => 'date_format:yy-m-d|nullable'
        ]);
        Payment::find($this->paymentId)->update($this->paymentData);
        if($this->billlateId != null){
            BillLate::find($this->billlateId)->update($this->billlateData);
        }
        
        
        $this->modalShowPaymentVisible = false;
        session()->flash('message', "Cập nhật thông tin thanh toán thành công");
    }

    public function updateShowJuridical($id)
    {
        $this->resetValidation();
        $this->juridicalId = $id;
        $this->modalShowJuridicalVisible = true;
        $this->juridicalData = Juridical::find($this->juridicalId)->toArray();
    }

    public function updateJuridical()
    {
        $this->ifDatedDefault();
        $this->ifSelectedDefault();
        $this->juridicalData['contract_id'] = $this->contractId;
        $this->validate();
        Juridical::find($this->juridicalId)->update($this->juridicalData);
        $this->modalShowJuridicalVisible = false;
        session()->flash('message', 'Cập nhật thông tin pháp lý thành công');
    }

    public function createShowModalBillLate($id)
    {
        // dd($this->billlateId);
        // dd($this->paymentId);
        $this->modalCreateBilllate = true;
        $this->billlateId = null;
        $this->infoBillLate = false;
    }

    public function createBillLate()
    {
        $this->billlateData['payment_id'] = $this->paymentId;
        // dd($this->billlateData);
        $this->validate([
            'billlateData.day_late' => 'required' ,
            'billlateData.batch_late' => 'required' ,
            'billlateData.money_late' => 'required' ,
            'billlateData.citation_rate' => 'required',
            'billlateData.number_notifi' => 'required',
            'billlateData.document' => 'required', 
            'billlateData.receipt_date' => 'required|date_format:yy-m-d'
        ]);
        $billData = BillLate::create($this->billlateData);
        Payment::find($this->paymentId)->update([
            'payment_status' => 1
        ]);
        $this->modalCreateBilllate = false;
        $this->infoBillLate = true;
        $this->billlateId = $billData->id;

        // $this->resetPage();
        session()->flash('message', 'Thêm thanh toán trễ hạn thành công');
    }

    public function export(){
        return Excel::download(new CustomerExport($this->customerData), 'customers.xlsx');
    }
//
//   public function downloadPDF()
//   {
//       return PDF::download(new CustomerPDF($this->customerData) ,'customers.pdf');
//
//   }
}
