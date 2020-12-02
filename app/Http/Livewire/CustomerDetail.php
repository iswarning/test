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

use App\Exports\CustomerExport;


class CustomerDetail extends Component
{
    use WithPagination;

    public $contractId;
    public $customerId;
    public $juridicalId;
    public $paymentId;
    public $billlateId;

    public $modalShowCustomerVisible = false;
    public $modalShowContractVisible = false;
    public $modalShowPaymentVisible = false;
    public $modalShowJuridicalVisible = false;
    public $infoBillLate = false;

    public $contractStatus;
    public $contractStatusCreated = [];
    public $contractInfo = [];
    public $bookHolder = [];

    public $customerData = [];
    public $paymentData = [];
    public $projectData = [];
    public $billlateData = [];
    public $juridicalData = [
        'liquidation' => true
    ];
    public $contractData = [
        'signed' => false
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
            'customerData.birthday' => 'required',
            'customerData.phone' => ['required', 'numeric'],
        ];

        if($this->modalShowContractVisible == true)
        {
            $rules = [
                'contractData.contract_no' => ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)],
                'contractData.type' => 'required',
                'contractData.status' => 'required',
                'contractData.lot_number' => 'required',
                'contractData.area_signed' => ['required', 'numeric'],
                'contractData.value' => 'required',
                'contractData.project_id' => 'required',
                'contractData.signed_date' => 'required',
                'contractData.signed' => 'required',
            ];
            if($this->contractId == null)
            {
                $rules['paymentData.payment_date_95'] = 'required';
                $rules['paymentData.payment_progress'] = 'required';
            }
        }

        if($this->modalShowPaymentVisible == true)
        {
            $rules = [
                'billlateData.day_late' => 'required',
                'billlateData.batch_late' => 'required',
                'billlateData.money_late' => 'required',
                'billlateData.citation_rate' => 'required',
                'billlateData.number_notifi' => 'required',
                'billlateData.document' => 'required',
                'billlateData.receipt_date' => 'required',
                'billlateData.payment_id' => 'required',
            ];

            if($this->billlateId != null)
            {
                $rules['paymentData.payment_date_95'] = 'required';
                $rules['paymentData.payment_progress'] = 'required';
                $rules['paymentData.contract_id'] = 'required';
            }
        }

        if($this->modalShowJuridicalVisible == true)
        {
            $rules = [
                'juridicalData.contract_info' => 'required',
                'juridicalData.status' => 'required',
                'juridicalData.notarized_date' => 'required',
                'juridicalData.registration_procedures' => 'required',
                'juridicalData.liquidation' => 'required',
                'juridicalData.bill_profile' => 'required',
                'juridicalData.book_holder' => 'required',
                'juridicalData.delivery_land_date' => 'required',
                'juridicalData.delivery_book_date' => 'required',
                'juridicalData.commitment' => 'required',
                'juridicalData.contract_id' => 'required',
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
            'customerData.phone.required' => 'Không thể để trống số điện thoại',
            'customerData.phone.numeric' => 'Số điện thoại phải là số',

            'contractData.contract_no.required' => 'Không thể để trống mã hợp đồng',
            'contractData.contract_no.unique' => 'Mã hợp đồng đã tồn tại',
            'contractData.type.required' => 'Không thể để trống loại hợp đồng',
            'contractData.lot_number.required' => 'Không thể để mã lô',
            'contractData.area_signed.required' => 'Không thể để trống diện tích ký',
            'contractData.value.required' => 'Không thể để trống giá bán',

            'paymentData.payment_date_95.required' => 'Không thể để trống ngày thanh toán đủ 95%',
            'paymentData.payment_progress.required' => 'Không thể để trống giá bán tiến độ thanh toán',

            'billlateData.day_late.required' => 'Không thể để trống ngày trễ',
            'billlateData.batch_late.required' => 'Không thể để trống đợt trễ',
            'billlateData.money_late.required' => 'Không thể để trống số tiền trễ',
            'billlateData.citation_rate.required' => 'Không thể để trống lãi phạt',
            'billlateData.number_notifi.required' => 'Không thể để trống số lần đã thông báo',
            'billlateData.document.required' => 'Không thể để trống văn bản',
            'billlateData.receipt_date.required' => 'Không thể để trống ngày khách nhận thông báo',

            'juridicalData.status.required' => 'Không thể để trống trạng thái',
            'juridicalData.notarized_date.required' => 'Không thể để trống ngày công chứng',
            'juridicalData.registration_procedures.required' => 'Không thể để trống thủ tục đăng bộ',
            'juridicalData.liquidation.required' => 'Không thể để trống thanh lý hợp đồng',
            'juridicalData.bill_profile.required' => 'Không thể để trống hồ sơ thu lai',
            'juridicalData.delivery_land_date.required' => 'Không thể để trống ngày bàn giao',
            'juridicalData.commitment.required' => 'Không thể để trống cam kết thỏa thuận',
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
        $this->resetValidation();
        $this->modalShowCustomerVisible = true;
        $this->customerId = $id;
        $this->customerData = Customers::find($this->customerId)->toArray();
    }

    public function updateCustomer()
    {
        $this->validate();
        Customers::find($this->customerId)->update($this->customerData);
        $this->modalShowCustomerVisible = false;
        session()->flash('message', 'Cap nhat thong tin khach hang thanh cong');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.customer-detail', [
            'contract' =>  Contracts::where('customer_id',$this->customerId)->get()
        ]);

    }

    public function createShowContract()
    {
        $this->contractData = [
            'signed' => false
        ];
        $this->contractId = null;
        $this->contractData = [];
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

    public function createJuridical()
    {
        $this->juridicalData['contract_id'] = $this->contractId;
        $this->juridicalData['liquidation'] = true;
        $this->validate();
        Juridical::create($this->juridicalData);
        $this->modalShowJuridicalVisible = false;
        session()->flash('message', 'Them thong tin phap ly thanh cong');
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
        $this->contractData['id'] = $this->contractId;
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Cap nhat thong tin hop dong thanh cong');
    }

    public function updateShowPaymentAndBill()
    {
        $this->resetValidation();
        $this->paymentData = Payment::find($this->paymentId)->toArray();
        $this->billlateData = BillLate::find($this->billlateId)->toArray();
        $this->modalShowPaymentVisible = true;
    }

    public function updatePaymentAndBill()
    {
        $this->validate();
        Payment::find($this->paymentId)->update($this->paymentData);
        BillLate::find($this->billlateId)->update($this->billlateData);
        $this->modalShowPaymentVisible = false;
        session()->flash('message', "Cap nhat thong tin thanh toan thanh cong");
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
        $this->juridicalData['contract_id'] = $this->contractId;
        $this->validate();
        Juridical::find($this->juridicalId)->update($this->juridicalData);
        $this->modalShowJuridicalVisible = false;
        session()->flash('message', 'Cap nhat thong tin phap ly thanh cong');
    }

    public function createShowModalBillLate($id)
    {
        $this->resetValidation();
        $this->paymentId = $id;
        $this->modalShowPaymentVisible = true;
        $this->infoBillLate = false;
    }

    public function createBillLate()
    {
        $this->billlateData['payment_id'] = $this->paymentId;
        $this->validate();
        BillLate::create($this->billlateData);
        $this->modalShowPaymentVisible = false;
        $this->infoBillLate = true;

        session()->flash('message', 'Them thanh toan tre han thanh cong');
    }




    public function export(){
        return Excel::download(new CustomerExport($this->customerData), 'customers.xlsx');
    }
}
