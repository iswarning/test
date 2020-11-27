<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contracts;
use App\Models\Payment;

class ContractDetail extends Component
{
    public $contractId;
    public $contractData;
    public $paymentData;
    public $modalFormVisible = false;

    public function mount($id)
    {
        $this->contractId = $id;
        $this->contractData = Contracts::find($this->contractId);
        $this->paymentData = Payment::where('contract_id',$this->contractId)->first();
    }

    public function render()
    {
        return view('livewire.contract-detail', [
            'contract' => $this->contractData
        ]);

    }

    public function createPayment()
    {

    }

    public function createShowModalPayment()
    {

    }
}
