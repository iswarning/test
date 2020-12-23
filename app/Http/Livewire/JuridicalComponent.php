<?php

namespace App\Http\Livewire;

use App\Models\Juridical;
use Livewire\Component;
use App\Enums\ContractInfo;
use App\Enums\BookHolder;

class JuridicalComponent extends Component
{
    public $juridicalId;
    public $juridicalData = [];
    public $contractInfo = [];
    public $bookHolder = [];
    public $contractId;
    public $modalShowJuridicalVisible = false;

    public function rules()
    {
        return [
            'juridicalData.contract_info' => 'required',
                'juridicalData.status' => 'required',
                'juridicalData.registration_procedures' => 'required',
                'juridicalData.book_holder' => 'required',
                // 'juridicalData.book_holder' => new RequiredIf(isset($this->juridicalData['book_holder']) && $this->juridicalData['book_holder'] == "Chọn bộ phận"),
                'juridicalData.contract_id' => 'required',
                'juridicalData.notarized_date' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            // 'juridicalData.contract_info.required' => 'Không thể để trống thông tin hợp đồng',
            'juridicalData.status.required' => 'Không thể để trống trạng thái',
            'juridicalData.registration_procedures.required' => 'Không thể để trống thủ tục đăng bộ',
            'juridicalData.book_holder.required' => 'Không thể để trống bộ phận' ,
            'juridicalData.contract_info.required' => 'Không thể để trống hợp đồng' ,
        ];
    }
    public function mount($id)
    {
        $this->contractId = $id;
        $this->contractInfo = ContractInfo::infoName;
        $this->bookHolder = BookHolder::roleName;
    }
    public function render()
    {
        return view('livewire.juridical-component',[
            'juridical' => Juridical::where('contract_id', $this->contractId)->first(),
        ]);
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
        session()->flash('message', 'Cập nhật thông tin pháp lý thành công');
    }

    public function createShowJuridical()
    {
        $this->reset();
        $this->modalShowJuridicalVisible = true;
    }
    
    public function createJuridical()
    {
        $this->juridicalData['contract_id'] = $this->contractId;
        $this->juridicalData['liquidation'] = true;
        $this->validate();
        Juridical::create($this->juridicalData);
        $this->modalShowJuridicalVisible = false;
        session()->flash('message', 'Thêm thông tin pháp lý thành công');
    }
}
