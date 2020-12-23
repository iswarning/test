<?php

namespace App\Http\Livewire;

use App\Models\BillLate;
use App\Models\Payment;
use Livewire\Component;

class PaymentComponent extends Component
{
    public $contractId;
    public $paymentId;
    public $paymentData = [];
    public $billlateData = [];
    public $billlateId;
    public $modalShowPaymentVisible = false;
    public $modalCreateBilllate = false;
    public $payment_date_95;

    public function mount($id)
    {
        $this->contractId = $id;
        $payment = Payment::where('contract_id', $this->contractId)->first();
        if(BillLate::where('payment_id', $payment->id)->first() != null){
            $this->billlateData = BillLate::where('payment_id', $payment->id)->first();
            $this->billlateId = $this->billlateData->id;
        }
    }

    public function rules()
    {

        $rules = [
            'paymentData.payment_progress' => 'required',
            'paymentData.contract_id' => 'required' ,
            'paymentData.payment_date_95' => 'nullable'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'paymentData.payment_progress.required' => 'Không thể để trống tiến độ thanh toán',
            
            'billlateData.day_late.required' => 'Không thể để trống ngày trễ',
            'billlateData.batch_late.required' => 'Không thể để trống đợt trễ',
            'billlateData.money_late.required' => 'Không thể để trống số tiền trễ',
            'billlateData.citation_rate.required' => 'Không thể để trống lãi phạt',
            'billlateData.number_notifi.required' => 'Không thể để trống số lần đã thông báo',
            'billlateData.document.required' => 'Không thể để trống văn bản',
            'billlateData.receipt_date.required' => 'Không thể để trống ngày khách nhận thông báo',
            'billlateData.receipt_date.date_format' => 'Ngày khách nhận thông báo không hợp lệ',
        ];
    }

    public function render()
    {
        $payment = Payment::where('contract_id', $this->contractId)->first();
        return view('livewire.payment-component', [
            'payment' => $payment,
            // 'billlate' => BillLate::where('payment_id', $payment->id)->first(),
        ]);
    }

    public function updateShowPaymentAndBill($id)
    {
        $this->paymentData = Payment::find($id)->toArray();
        
        if(BillLate::where('payment_id',$id)->first() != null){
            $this->billlateData = BillLate::where('payment_id',$id)->first()->toArray();
            $this->billlateId = $this->billlateData['id'];
        }
        $this->modalShowPaymentVisible = true;
    }
    
    public function billlateRule()
    {
        return [
            'billlateData.day_late' => 'required' ,
            'billlateData.batch_late' => 'required' ,
            'billlateData.money_late' => 'required' ,
            'billlateData.citation_rate' => 'required',
            'billlateData.number_notifi' => 'required',
            'billlateData.document' => 'required', 
            'billlateData.receipt_date' => 'required|date_format:yy-m-d'
        ];
    }

    public function updatePaymentAndBill()
    {
        // $this->ifDatedDefault();
        // $this->ifSelectedDefault();
        $this->validate();
        Payment::find($this->paymentId)->update($this->paymentData);
        if(!empty($this->billlateId)){
            BillLate::find($this->billlateId)->update($this->billlateData);
        }
        
        
        $this->modalShowPaymentVisible = false;
        session()->flash('message', "Cập nhật thông tin thanh toán thành công");
    }

    public function createShowModalBillLate($id)
    {
        $this->reset();
        $this->modalCreateBilllate = true;
        $this->paymentId = $id;
        $this->billlateData['payment_id'] = $this->paymentId;
    }

    public function createBillLate()
    {
        $this->validate($this->billlateRule());
        $billData = BillLate::create($this->billlateData);
        Payment::find($this->paymentId)->update([
            'payment_status' => 1
        ]);
        $this->modalCreateBilllate = false;
        $this->billlateId = $billData->id;
        session()->flash('message', 'Thêm thanh toán trễ hạn thành công');
    }
}
