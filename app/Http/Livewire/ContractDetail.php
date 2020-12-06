<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contracts;
use App\Models\Payment;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
use App\Enums\ContractInfo;
use App\Enums\BookHolder;
use App\Http\Livewire\CustomerDetail;

class ContractDetail extends Component
{
    public $contractId;

    public function render()
    {
        return view('livewire.contract-detail');
    }
}
