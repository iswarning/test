<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentDetail extends Component
{
    
    public function render()
    {
        return view('livewire.payment-detail', [
            'contractTime' => $this->contractTime
        ]);
    }
}
