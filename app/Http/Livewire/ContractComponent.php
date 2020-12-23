<?php

namespace App\Http\Livewire;

use App\Models\Contracts;
use Livewire\Component;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\Rule;
use App\Enums\ContractStatus;
use App\Enums\ContractStatusCreated;
use App\Models\Project;

class ContractComponent extends Component
{
    public $contractId;
    public $contractData = [];
    public $contractStatus = [];
    public $contractStatusCreated = [];
    public $modalShowContractVisible = false;
    
    public function mount($id)
    {
        $this->contractId = $id;
        $this->contractStatus = ContractStatus::statusName;
        $this->contractStatusCreated = ContractStatusCreated::statusName;
    }

    public function rules()
    {
        $rules['contractData.contract_no'] = ['required', Rule::unique('contracts', 'contract_no')->ignore($this->contractId)];
        $rules['contractData.type'] = ['required',];
        $rules['contractData.status'] = 'required';
        $rules['contractData.status_created_by'] = new RequiredIf($this->contractData['status'] != 2);
        $rules['contractData.lot_number'] = ['required',];
        $rules['contractData.area_signed'] = 'required|max:4';

        $rules['contractData.value'] = 'required';
        $rules['contractData.project_id'] = 'required';
        $rules['contractData.signed_date'] = 'required|date_format:yy-m-d';
        return $rules;
    }

    public function messages()
    {
        return [
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
        ];
    }
    

    public function render()
    {
        return view('livewire.contract-component', [
            'contract' => Contracts::find($this->contractId),
            'projects' => Project::all(),
        ]);
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
        // $this->ifDatedDefault();
        // $this->ifSelectedDefault();
        // $this->contractData['id'] = $this->contractId;
        $this->validate();
        Contracts::find($this->contractId)->update($this->contractData);
        $this->modalShowContractVisible = false;
        session()->flash('message', 'Cập nhật thông tin hợp đồng thành công');
    }
}
